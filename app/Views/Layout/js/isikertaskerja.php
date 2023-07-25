<script src="<?= base_url('/assets/js/pages/jquery.min.js') ?>"></script>
<script src="<?= base_url('/assets/js/add/select2.min.js') ?>"></script>
<script src="<?= base_url('/assets/js/jquery.validate.min.js') ?>"></script>
<script src="<?= base_url('/assets/js/easy-number-separator.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('.form-select').select2({
            theme: "bootstrap"
        });
    });

    console.log($('#nilai_bmn_minus').val())
    $('#nilai_bmn_minus').on('keyup', function() {
        console.log(this.value)
    })
</script>

<script>
    const barang = '<?= $bmn['kbrdn_brg']; ?>';
    const btd = '<?= $bmn['kategori_btd']; ?>';
    const br = '<?= $bmn['kategori_br']; ?>';

    $(document).on('change', 'input[name="keberadaan-barang"]', function() {
        checkKategori(this.value)
    })
    $(document).ready(function() {
        checkKategori(barang)
    })

    function checkKategori(val) {
        if (val == 'BTD') {
            $('#kategori_btd').removeClass('d-none')
            $('#kategori_bb').addClass('d-none')
            btd != '' && btd != '0' ? $("select[name='kategori_btd']").val(btd).trigger("change") : ''

        } else if (val == 'BR') {
            $('#kategori_btd').addClass('d-none')
            $('#kategori_bb').removeClass('d-none')
            br != '' && br != '0' ? $("select[name='kategori_br']").val(br).trigger("change") : ''
        } else {
            $('#kategori_btd').addClass('d-none')
            $('#kategori_bb').addClass('d-none')
        }
    }
</script>

<script>
    $(document).ready(function() {
        jQuery.validator.addMethod("conditionalRequired", function(value, element) {
            var keberadaanBarang = $("input[name='keberadaan-barang']:checked").val();
            var kategoriBr = $("select[name='kategori_br']").val();
            var kategoriBtd = $("select[name='kategori_btd']").val();
            if (keberadaanBarang === "BR" && kategoriBr == null) {
                field = 'kategori barang berlebih'
                return false;
            } else if (keberadaanBarang === "BTD" && kategoriBtd == null) {
                field = 'kategori barang tidak ditemukan'
                return false;
            }
            return true;
        }, "Silahkan pilih kategori barang.");
        $("#kertas-kerja").validate({
            errorLabelContainer: "#errorContainer",
            rules: {
                "kondisi-barang": "required",
                "keberadaan-barang": "required",
                "pegawai": "required",
                "kategori_br": {
                    conditionalRequired: true
                },
                "kategori_btd": {
                    conditionalRequired: true
                },
                "nama-gedung": "required",
                "nama-ruangan": "required",
                "pelabelan": "required",
                "status-psp": "required",
            },
            messages: {
                "kondisi-barang": "Silahkan pilih kondisi barang.",
                "keberadaan-barang": "Silahkan pilih keberadaan barang.",
                "pegawai": "Silahkan pilih pengguna barang.",
                "nama-gedung": "Silahkan pilih gedung.",
                "nama-ruangan": "Silahkan pilih ruangan.",
                "pelabelan": "Silahkan pilih status pelabelan kodefikasi.",
                "status-psp": "Silahkan pilih status PSP.",
            },
            submitHandler: function(form) {
                form.submit();
            },
            invalidHandler: function(event, validator) {
                $("#errorContainer").show();
            },
            success: function(label, element) {
                $("#errorContainer").hide();
            }
        });
    })
</script>