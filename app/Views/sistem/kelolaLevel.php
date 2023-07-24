<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Kelola Level</h3>
            <p class="text-subtitle text-muted">Daftar Level yang ada di SIBAMIRA</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kelola Level</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-12">
            <div class="card card-primary card-outline" style="border: #3c4b64;">
                <div class="card-body box-profile">
                    <div class="row">
                        <form method="" action="" class="col-md-5 py-1">
                            <div class="float-left">
                                <div class="input-group">
                                    <button type="button" class="btn btn-info tombol" style="background-color: #3c4b64; border:none;" data-bs-toggle="modal" data-bs-target="#modal-tambah"><i class="fas fa-plus mr-2"></i> Tambah</button>
                                </div>
                            </div>
                        </form>
                        <div class="col-md-1">
                        </div>
                        <div class="col-md-6 py-1 ">
                            <div class="input-group input-group-md float-end" style="width: 250px">
                                <input type="text" id="pencarian" name="table_search" class="form-control float-left" placeholder="Search ..." />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body table-responsive overflow-hidden">
                                <table class="table table-hover text-nowrap" id="tabelData">
                                    <thead>
                                        <tr>
                                            <th>LEVEL/ROLE</th>
                                            <th>HAK AKSES</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($list_level as $level) : ?>
                                            <tr>
                                                <td><?= $level['nama_level']; ?>
                                                <td><a href="<?= base_url('/editKelolaLevel/' . $level['id']) ?>" type="button" class="btn btn-info btn-sm tombol" style="background-color: #3c4b64; border:none;">Edit Hak Akses</a></td>
                                                <td>
                                                    <button id="btn-edit" type="button" class="btn btn-info btn-sm tombol" style="background-color: #2D95C9; border:none;" data-id="<?= $level["id"] ?>" data-nama_level="<?= $level["nama_level"] ?>" data-bs-toggle="modal" data-bs-target="#modal-edit">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="<?= $id_modal; ?>" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <form action="<?= base_url('/updateKelolaLevel/' . $level_id) ?>" method="POST" class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Hak Akses Menu</h4>
                <a href="<?= base_url('/kelolaLevel') ?>" type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                <div class="card-body table-responsive p-0">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="kepala-tabel">
                                    <th style="width: 10px">NO.</th>
                                    <th>MENU</th>
                                    <th style="width: 60px">VIEW</th>
                                    <th style="width: 60px">ADD</th>
                                    <th style="width: 60px">EDIT</th>
                                    <th style="width: 60px">DELETE</th>
                                    <th style="width: 60px">PRINT</th>
                                    <th style="width: 60px">UPLOAD</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 0; $i < count($list_menu); $i++) : ?>
                                    <?php $hiddenMenu = '' ?>

                                    <?php if ($list_menu[$i]['is_active'] == 'N') {
                                        $hiddenMenu = 'sembunyi';
                                    } ?>

                                    <tr class="<?= $hiddenMenu; ?>">
                                        <td class="sel-menu"><strong><?= $list_menu[$i]['id']; ?></strong></td>
                                        <td class="sel-menu"><strong><?= $list_menu[$i]['nama_menu']; ?></strong></td>
                                        <td class="sel">
                                            <label for="view<?= $i; ?>" class="ikon-sel">
                                                <input class="d-none" type="checkbox" name="view<?= $i; ?>" id="view<?= $i; ?>" <?= $list_menu[$i]['view_level'] == 'Y' ? 'checked' : ''; ?> />
                                                <i class="bi <?= $list_menu[$i]['view_level'] == 'Y' ? 'bi-check-circle text-success' : 'bi-x-circle text-danger'; ?>"></i>
                                            </label>
                                        </td>
                                        <td class="sel sel-disabled">

                                        </td>
                                        <td class="sel sel-disabled">

                                        </td>
                                        <td class="sel sel-disabled">

                                        </td>
                                        <td class="sel sel-disabled">

                                        </td>
                                        <td class="sel sel-disabled">

                                        </td>
                                    </tr>

                                    <?php for ($j = 0; $j < count($list_submenu); $j++) : ?>
                                        <?php $hiddenSubmenu = '' ?>
                                        <?php if ($list_submenu[$j]['menu_id'] == $list_menu[$i]['id']) : ?>
                                            <?php if ($list_submenu[$j]['is_active'] == 'N') {
                                                $hiddenSubmenu = 'sembunyi';
                                            } ?>
                                            <tr class="<?= $hiddenSubmenu; ?>">
                                                <td></td>
                                                <td><?= $list_submenu[$j]['nama_submenu']; ?></td>
                                                <td class="sel">
                                                    <label for="view_submenu<?= $j; ?>" class="ikon-sel">
                                                        <input class="d-none" type="checkbox" name="view_submenu<?= $j; ?>" id="view_submenu<?= $j; ?>" <?= $list_submenu[$j]['view_level'] == 'Y' ? 'checked' : ''; ?> />
                                                        <i class="bi <?= $list_submenu[$j]['view_level'] == 'Y' ? 'bi-check-circle text-success' : 'bi-x-circle text-danger'; ?>"></i>
                                                    </label>
                                                </td>
                                                <td class="sel">
                                                    <label for="add_submenu<?= $j; ?>" class="ikon-sel">
                                                        <input class="d-none" type="checkbox" name="add_submenu<?= $j; ?>" id="add_submenu<?= $j; ?>" <?= $list_submenu[$j]['add_level'] == 'Y' ? 'checked' : ''; ?> />
                                                        <i class="bi <?= $list_submenu[$j]['add_level'] == 'Y' ? 'bi-check-circle text-success' : 'bi-x-circle text-danger'; ?>"></i>
                                                    </label>
                                                </td>
                                                <td class="sel">
                                                    <label for="edit_submenu<?= $j; ?>" class="ikon-sel">
                                                        <input class="d-none" type="checkbox" name="edit_submenu<?= $j; ?>" id="edit_submenu<?= $j; ?>" <?= $list_submenu[$j]['edit_level'] == 'Y' ? 'checked' : ''; ?> />
                                                        <i class="bi <?= $list_submenu[$j]['edit_level'] == 'Y' ? 'bi-check-circle text-success' : 'bi-x-circle text-danger'; ?>"></i>
                                                    </label>
                                                </td>
                                                <td class="sel">
                                                    <label for="delete_submenu<?= $j; ?>" class="ikon-sel">
                                                        <input class="d-none" type="checkbox" name="delete_submenu<?= $j; ?>" id="delete_submenu<?= $j; ?>" <?= $list_submenu[$j]['delete_level'] == 'Y' ? 'checked' : ''; ?> />
                                                        <i class="bi <?= $list_submenu[$j]['delete_level'] == 'Y' ? 'bi-check-circle text-success' : 'bi-x-circle text-danger'; ?>"></i>
                                                    </label>
                                                </td>
                                                <td class="sel">
                                                    <label for="print_submenu<?= $j; ?>" class="ikon-sel">
                                                        <input class="d-none" type="checkbox" name="print_submenu<?= $j; ?>" id="print_submenu<?= $j; ?>" <?= $list_submenu[$j]['print_level'] == 'Y' ? 'checked' : ''; ?> />
                                                        <i class="bi <?= $list_submenu[$j]['print_level'] == 'Y' ? 'bi-check-circle text-success' : 'bi-x-circle text-danger'; ?>"></i>
                                                    </label>
                                                </td>
                                                <td class="sel">
                                                    <label for="upload_submenu<?= $j; ?>" class="ikon-sel">
                                                        <input class="d-none" type="checkbox" name="upload_submenu<?= $j; ?>" id="upload_submenu<?= $j; ?>" <?= $list_submenu[$j]['upload_level'] == 'Y' ? 'checked' : ''; ?> />
                                                        <i class="bi <?= $list_submenu[$j]['upload_level'] == 'Y' ? 'bi-check-circle text-success' : 'bi-x-circle text-danger'; ?>"></i>
                                                    </label>
                                                </td>
                                            </tr>
                                        <?php endif; ?>

                                    <?php endfor; ?>


                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <div class="modal-footer justify-content-between">

                <a href="<?= base_url('/kelolaLevel') ?>" type="button" class="btn btn-default"> Tutup</a>

                <button type="submit" class="btn btn-info tombol" style="background-color: #3c4b64; border:none;">Simpan</button>
            </div>
        </form>
    </div>
</div>


<div class="modal fade" style="padding-top: 13%;" id="modal-tambah">
    <div class="modal-dialog">
        <form action="<?= base_url('/saveLevel') ?>" method="POST" class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Level</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Level</label>
                    <input type="nama_level" name="nama_level" class="form-control" placeholder="Nama Level ...">
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-info tombol" style="background-color: #3c4b64; border:none;">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" style="padding-top: 13%;" id="modal-edit">
    <div class="modal-dialog">
        <form action="<?= base_url("/updateNamaLevel") ?>" method="POST" class="modal-content">
            <input type="text" name="id_level" id="id_level" class="d-none">
            <div class="modal-header">
                <h4 class="modal-title">Edit Level</h4>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Level</label>
                    <input type="nama_level" name="nama_level" id="nama_level" class="form-control">
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-info tombol" style="background-color: #3c4b64; border:none;">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade text-left modal-borderless" id="modal-editt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import KKI</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form action="<?= base_url('/import-kki'); ?>" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <fieldset class="form-group">
                        <select class="form-select" id="basicSelect" name="satker">
                            <option>- Satker -</option>

                        </select>
                    </fieldset>
                    <!-- class="basic-filepond" -->
                    <input type="file" name="filekki" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                        <span>Batal</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1">
                        <span>Import</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


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


<?= $this->endSection(); ?>