<script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
<script src="assets/js/pages/dashboard.js"></script>
<script src="assets/extensions/filepond/filepond.js"></script>
<script src="assets/js/pages/filepond.js"></script>
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
    $(document).ready(function() {
        $('.form-select').select2({
            theme: "bootstrap"
        });
        $('.select-satker2').select2({
            dropdownParent: $('#modal-import'),
            theme: "bootstrap"
        });
    });

    $(document).on('change', '#satker-kki', function() {
        if ($(this).val() != '') {
            $('#btn-submit').attr('disabled', false)
        }
    })
</script>