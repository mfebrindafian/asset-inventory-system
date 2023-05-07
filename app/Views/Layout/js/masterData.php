<script src="<?= base_url('/assets/js/pages/jquery.min.js') ?>"></script>
<script src="<?= base_url('/assets/js/add/select2.min.js') ?>"></script>
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

    $(document).on('click', '#btn-edit-satker', function() {
        $('#id-satker-edit').val($(this).data('id'))
        $('#nama-satker-edit').val($(this).data('nama-satker'))
        $('#pilih-ref-satker-edit').val($(this).data('ref-satker'))
    })

    $(document).on('click', '#btn-hapus-satker', function() {
        $('#id-satker-hapus').val($(this).data('id'))
        $('#nama-satker-hapus').text($(this).data('nama-satker'))
    })
</script>