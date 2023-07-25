<script src="<?= base_url('/assets/js/pages/jquery.min.js') ?>"></script>
<script src="<?= base_url('/assets/js/add/select2.min.js') ?>"></script>
<script src="<?= base_url('/assets/js/jquery.validate.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        $("#inventarisasi").validate({
            errorLabelContainer: "#errorContainer",
            rules: {
                "satker": "required",
                "jenis-inventarisasi": "required",
            },
            messages: {
                "satker": "Silahkan pilih satker terlebih dahulu",
                "jenis-inventarisasi": "Silahkan pilih jenis inventarisasi terlebih dahulu.",
            },
            submitHandler: function(form) {
                form.submit();
            },
        });
    })
</script>
<script>
    $(document).ready(function() {
        $('.form-select').select2({
            theme: "bootstrap"
        });
    });
</script>