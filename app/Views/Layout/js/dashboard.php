<script src="/assets/extensions/apexcharts/apexcharts.min.js"></script>
<script src="/assets/js/pages/dashboard.js"></script>
<script src="<?= base_url('/assets/js/pages/jquery.min.js') ?>"></script>
<script src="<?= base_url('/assets/js/add/select2.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('.form-select').select2({
            theme: "bootstrap"
        });
    });
</script>
<script>
    $('#pilihSatker').change(function() {
        var jenis = ['all', 'sudah', 'belum'];
        let satker = $(this).val();

        console.log(satker)
        $.ajax({
            dataType: "json",
            url: "<?= base_url('/APISatkerOnDashboard') ?>/" + satker,
            success: function(data) {
                $(".satker-apa").each(function(index) {
                    if (index == 0 && satker != 'all') {
                        $(this).text('pada ' + data['nama_satker']);
                    } else if (index == 0 && satker == 'all') {
                        $(this).text('');
                    } else {
                        $(this).text(data['nama_satker']);
                    }
                });
                $.each(jenis, function(indexx) {
                    $("." + jenis[indexx]).each(function(index) {
                        $(this).text(data['data_bmn'][jenis[indexx]][index + 1]);
                    });
                });

                $('.konten-dashboard').find('a').each(function() {
                    let link = $(this).attr('href')
                    let finalLink = link.split('/');
                    var result = '/' + finalLink[finalLink.length - 4] + '/' + finalLink[finalLink.length - 3] + '/' + finalLink[finalLink.length - 2] + '/' + satker;
                    $(this).attr('href', result)
                });
            }
        });
    })
</script>