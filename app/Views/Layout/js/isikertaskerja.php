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
    console.log(
        $('input[name="keberadaan-barang"]').val()
    )

    $(document).on('change', 'input[name="keberadaan-barang"]', function() {
        if ($(this).val() == 'BTD') {
            $('#kategori_btd').removeClass('d-none')
            $('#kategori_bb').addClass('d-none')
        } else if ($(this).val() == 'BR') {
            $('#kategori_btd').addClass('d-none')
            $('#kategori_bb').removeClass('d-none')
        } else {
            $('#kategori_btd').addClass('d-none')
            $('#kategori_bb').addClass('d-none')
        }
    })
</script>