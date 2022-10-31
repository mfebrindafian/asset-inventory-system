<script src="<?= base_url('/assets/js/pages/jquery.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('input[type="checkbox"]').change(function() {
            if ($(this).prop('checked') == true) {
                $(this).siblings().addClass('bi-check-circle text-success').removeClass('bi-x-circle text-danger')
            } else if ($(this).prop('checked') == false) {
                $(this).siblings().removeClass('bi-check-circle text-success').addClass('bi-x-circle text-danger')
            }
        })
    })
</script>

<script>
    //Mengambil Data edit dengan menggunakan Jquery
    $(document).on('click', '#btn-edit', function() {
        $('#id_level').val($(this).data('id'));
        $('#nama_level').val($(this).data('nama_level'));
    })
</script>

<script>
    $(document).ready(function() {
        $('#modal-hakAkses').modal('show');
    })
</script>

<script type="text/javascript">
    $('#tabelData').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        'ordering': false,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "pageLength": 10

    });

    $('#tabelData_wrapper').children().first().addClass('d-none')
    $('.dataTables_paginate').addClass('Pager2').addClass('float-right')
    $('.dataTables_info').addClass('text-sm text-gray py-2')
    $('.dataTables_paginate').parent().parent().addClass('card-footer clearfix')

    $(document).on('keyup', '#pencarian', function() {
        $('#tabelData').DataTable().search(
            $(this).val()
        ).draw();
    })
</script>