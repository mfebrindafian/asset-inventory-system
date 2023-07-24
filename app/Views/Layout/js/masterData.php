<script src="<?= base_url('/assets/js/pages/jquery.min.js') ?>"></script>
<script src="<?= base_url('/assets/js/add/select2.min.js') ?>"></script>
<script src="<?= base_url('/assets/js/datatable.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('table').DataTable({
            pageLength: 20,
        })
        $('.dataTables_length').addClass('d-none');
        $('.dataTables_filter').addClass('d-none');
        $('.dataTables_info').addClass('d-none');
        $('.dataTables_paginate').addClass('mt-4');
    });

    $(document).on('keyup', '#searchbar', function() {
        $('table').DataTable().search($('#searchbar').val()).draw();
    });
</script>
<script>
    $(document).on('click', '#btn-edit-gedung', function() {
        $('#id-gedung-edit').val($(this).data('id'))
        $('#nama-gedung-edit').val($(this).data('nama-gedung'))
        $('#lokasi-edit').val($(this).data('lokasi'))
        $('#unit-kerja-edit').val($(this).data('unit-kerja'))
    })

    $(document).on('click', '#btn-hapus-gedung', function() {
        $('#id-gedung-hapus').val($(this).data('id'))
        $('#nama-gedung-hapus').text($(this).data('nama-gedung'))
    })

    $(document).on('click', '#btn-edit-ruangan', function() {
        $('#id-ruangan-edit').val($(this).data('id'))
        $('#nama-ruangan-edit').val($(this).data('nama-ruangan'))
        $('#kapasitas-edit').val($(this).data('kapasitas'))
        $('#pilih-gedung-edit').val($(this).data('pilih-gedung'))
    })

    $(document).on('click', '#btn-hapus-ruangan', function() {
        $('#id-ruangan-hapus').val($(this).data('id'))
        $('#nama-ruangan-hapus').text($(this).data('nama-ruangan'))
    })

    $(document).on('click', '#btn-edit-subsatker', function() {
        $('#id-subsatker-edit').val($(this).data('id'))
        $('#nama-satker-edit').val($(this).data('nama-subsatker'))
        $('#ref-unit-kerja-edit').val($(this).data('ref-subsatker')).trigger('change')
    })

    $(document).on('click', '#btn-hapus-subsatker', function() {
        $('#id-subsatker-hapus').val($(this).data('id'))
        $('#nama-subsatker-hapus').text($(this).data('nama-subsatker'))
    })

    $(document).ready(function() {
        $('#ref-unit-kerja').select2({
            dropdownParent: $('#modal-tambah-satker'),
            theme: "bootstrap",
        });
        $('#ref-unit-kerja-edit').select2({
            dropdownParent: $('#modal-edit-satker'),
            theme: "bootstrap",
        });
    });
</script>

<script>
    $(document).on('click', '#btn-hapus-gedung', function() {
        $('#id_gedung_post').val($(this).data('id'));
    })
</script>