<script src="<?= base_url('/assets/js/pages/jquery.min.js') ?>"></script>
<script>
    $(document).on('click', '#btn-edit-menu', function() {
        $('#id_menu').val($(this).data('id'))
        $('#nama_menu').val($(this).data('nama_menu'))
        $('#link').val($(this).data('link'))
        $('#icon').val($(this).data('icon'))
        $('#urutan').val($(this).data('urutan'))
        $('#is_active').val($(this).data('is_active'))
    })
</script>