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
    $('#satker, #jenis-rekapitulasi').change(function() {
        $(document).ajaxStart(function() {
            $('#complex').addClass('d-none');
            $('#simple').addClass('d-none');
            $('#loaders').removeClass('d-none');
        }).ajaxStop(function() {
            $('#loaders').addClass('d-none')
            window.scrollTo({
                top: document.body.scrollHeight,
                behavior: 'smooth'
            })
        });
        tableRender()
    })

    const rupiah = (money) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(money);
    }

    function tableRender() {
        var satker = $('#satker').val()
        var simple = ['2', '3', '7']
        let tipe = ''
        let jenis = $('#jenis-rekapitulasi').val();
        if (jQuery.inArray(jenis, simple) >= 0) {
            tipe = 'simple'
        } else {
            tipe = 'complex'
        }
        if (jenis != null && satker != null) {
            $.ajax({
                dataType: "json",
                url: "<?= base_url('/APIrekapitulasi') ?>/" + jenis + '/' + satker,
                statusCode: {
                    500: function() {
                        $('#complex').addClass('d-none')
                        $('#simple').addClass('d-none')
                        $('#jenis').text('')
                        alert("500 (Internal Server Error)!");
                    }
                },
                success: function(data) {
                    $('#jenis').text(data['nama_jenis'])
                    var trIsi = '';
                    if (tipe == 'simple') {
                        for (i = 1; i <= 4; i++) {
                            trIsi += '<tr><td class="text-start">' + data[i]['nama_akun'] + '</td><td>' + data[i]['inv_jumlah'] + '</td><td>' + rupiah(data[i]['inv_nilai']) + '</td><td></td></tr>'
                        }
                        var trTotal = '<tr><th>Total</th><th>' + data['total']['inv_jumlah'] + '</th><th>' + rupiah(data['total']['inv_nilai']) + '</th><th></th></tr>'

                    } else if (tipe == 'complex') {
                        for (i = 1; i <= 4; i++) {
                            trIsi += '<tr><td class="text-start">' + data[i]['nama_akun'] + '</td><td>' + data[i]['adm_jumlah'] + '</td><td>' + rupiah(data[i]['adm_nilai']) + '</td><td>' + data[i]['inv_jumlah'] + '</td><td>' + rupiah(data[i]['inv_nilai']) + '</td><td>' + data[i]['selisih_jumlah'] + '</td><td>' + rupiah(data[i]['selisih_nilai']) + '</td><td></td></tr>'
                        }
                        var trTotal = '<tr><th>Total</th><th>' + data['total']['adm_jumlah'] + '</th><th>' + rupiah(data['total']['adm_nilai']) + '</th><th>' + data['total']['inv_jumlah'] + '</th><th>' + rupiah(data['total']['inv_nilai']) + '</th><th>' + data['total']['selisih_jumlah'] + '</th><th>' + rupiah(data['total']['selisih_nilai']) + '</th><th></th></tr>'

                    }
                    if (tipe == 'simple') {
                        $('#simple').removeClass('d-none')
                        $('#complex').addClass('d-none')
                    } else {
                        $('#simple').addClass('d-none')
                        $('#complex').removeClass('d-none')
                    }

                    $('#' + tipe + '-table').empty()
                    $('#' + tipe + '-table').append(trIsi)
                    $('#' + tipe + '-table').append(trTotal)
                }

            });
        }
    }
</script>