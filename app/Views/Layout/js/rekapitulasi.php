<script src="<?= base_url('/assets/js/pages/jquery.min.js') ?>"></script>
<script>
    $('#jenis-rekapitulasi').change(function() {
        let jenis = $(this).val();
        $(".tab").each(function(index) {
            if (jenis == index) {
                $(this).removeClass('d-none');
            } else {
                $(this).addClass('d-none');
            }
        });
    })
</script>