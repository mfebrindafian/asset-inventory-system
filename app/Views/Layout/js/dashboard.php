<script src="/assets/extensions/apexcharts/apexcharts.min.js"></script>
<script src="/assets/js/pages/dashboard.js"></script>
<script src="<?= base_url('/assets/js/pages/jquery.min.js') ?>"></script>
<script>
    $('#pilihSatker').change(function() {
        var jenis = ['all', 'sudah', 'belum'];
        let satker = $(this).val();
        $.ajax({
            dataType: "json",
            url: "<?= base_url('/APISatkerOnDashboard') ?>/" + satker,
            success: function(data) {
                $(".satker-apa").each(function(index) {
                    if (index == 0 && satker != 'all') {
                        $(this).text('di ' + data['nama_satker']);
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
            }
        });
    })
</script>