<script src="<?= base_url('/assets/js/pages/jquery.min.js') ?>"></script>
<script src="<?= base_url('/assets/js/add/select2.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('.form-select').select2({
            dropdownParent: $('.modal'),
            theme: "bootstrap",
        });
    });
</script>