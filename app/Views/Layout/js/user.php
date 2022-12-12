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
<script>
    $(document).ready(function() {
        $('.leveling input[type="checkbox"]').change(function() {
            if ($(this).prop('checked') == true) {
                $(this).parent().toggleClass('active')
                $(this).siblings().removeClass().addClass('bi bi-check-square')
            } else if ($(this).prop('checked') == false) {
                $(this).parent().toggleClass('active')
                $(this).siblings().removeClass().addClass('bi bi-square')
            }
        })
    })
</script>