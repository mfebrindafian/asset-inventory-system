<script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
<script src="assets/js/pages/dashboard.js"></script>
<script src="assets/extensions/filepond/filepond.js"></script>
<script src="assets/js/pages/filepond.js"></script>
<script src="<?= base_url('/assets/js/pages/jquery.min.js') ?>"></script>
<script src="<?= base_url('/assets/js/add/select2.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('.form-select').select2({
            theme: "bootstrap"
        });
    });

    $(document).on('change', '#satker-kki', function() {
        if ($(this).val() != '') {
            $('#btn-submit').attr('disabled', false)
        }
    })
</script>