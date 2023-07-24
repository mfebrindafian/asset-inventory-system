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
        $('#satker-tambah').select2({
            dropdownParent: $('#modal-tambah'),
            theme: "bootstrap",
        });
        $('#satker-edit').select2({
            dropdownParent: $('#modal-edit'),
            theme: "bootstrap",
        });
    });
</script>
<script>
    $(document).ready(function() {
        $(document).on('change', '.leveling input[type="checkbox"]', function() {
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

<script>
    $(document).ready(function() {
        $('#cari-pegawai-tambah').select2({
            dropdownParent: $('#modal-tambah'),
            theme: "bootstrap",
            placeholder: 'Cari Nama Pegawai',
            minimumInputLength: 2,
            ajax: {
                type: "POST",
                url: '<?= base_url('/APIUser') ?>',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        nama_pegawai: params.term
                    }
                },
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: (item.gelar_depan != null ? item.gelar_depan : '') + ' ' + (item.nama_pegawai) + ' ' + (item.gelar_belakang != null ? item.gelar_belakang : ''),
                                id: item.user_id,
                                nip: item.nip
                            }
                        })
                    }
                },
                cache: true
            }
        });
        $('#cari-pegawai-tambah').on('select2:select', function(e) {
            var data = e.params.data;
            $('.nama-fill').html(data.text);
            $('.nip-fill').html(data.nip);
        });
    });
</script>
<script>
    $(document).on('change', '#level3', function() {
        if ($('#level3').is(':checked')) {
            $('#satker-tambah').parent().removeClass('d-none')
        } else {
            $('#satker-tambah').parent().addClass('d-none')
        }
    })
</script>

<script>
    $(document).on('click', '#btn-edit-user', function() {
        $.ajax({
            type: "GET",
            url: '<?= base_url('/APIEditUser') ?>/' + $(this).data('id'),
            success: function(data) {
                const data_pegawai = JSON.parse(data)
                const pegawai = data_pegawai.data_pegawai;
                const namaLengkap = (pegawai.depan != null ? pegawai.gelar_depan : '') + ' ' + (pegawai.nama_pegawai) + ' ' + (pegawai.gelar_belakang != null ? pegawai.gelar_belakang : '')
                $('.nama-fill-edit').html(namaLengkap)
                $('.nip-fill-edit').html(pegawai.nip)

                const userLevels = data_pegawai.level.map((obj) => obj.level_id);
                $(".checkbox-level .level_id_edit").each(function() {
                    if (userLevels.includes($(this).val())) {
                        $(this).attr('checked', true)
                        $(this).parent().removeClass('active')
                        $(this).siblings().removeClass().addClass('bi bi-check-square')
                    } else {
                        $(this).attr('checked', false)
                        $(this).parent().addClass('active')
                        $(this).siblings().removeClass().addClass('bi bi-square')
                    }
                });

                $('#id_pegawai').val(pegawai.user_id)

                for (i = 0; i < userLevels.length; i++) {
                    if (userLevels[i] == "3") {
                        $('#satker-edit').parent().removeClass('d-none')
                        $('#satker-edit').val(data_pegawai.level[i].satker_id).trigger('change')
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error(textStatus, errorThrown);
            }
        });
    })
</script>

<script>
    $(document).on('click', '#btn-hapus-user', function() {
        $('#id-user-hapus').val($(this).data('id'))
        $('#nama-user-hapus').text($(this).data('nama-user'))
    })
</script>