<script src="<?= base_url('/assets/js/pages/jquery.min.js') ?>"></script>
<script src="<?= base_url('/assets/js/datatable.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('#tabelData').DataTable({
            pageLength: 20,
        })
        $('.dataTables_length').addClass('d-none');
        $('.dataTables_filter').addClass('d-none');
        $('.dataTables_info').addClass('mt-4');
        $('.dataTables_paginate').addClass('mt-4');
    });

    $(document).on('keyup', '#searchbar', function() {
        $('table').DataTable().search($('#searchbar').val()).draw();
    });
</script>
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