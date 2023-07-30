<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Daftar Sub Satuan Unit Kerja</h3>
            <p class="text-subtitle text-muted">Berikut merupakan daftar Sub Satuan Unit Kerja</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Kelola Sub Satuan Unit Kerja</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-12">
            <div class="row mb-4">
                <div class="col-5">
                    <div class="form-group">
                        <input type="text" class="form-control" name="" id="searchbar" placeholder="Cari ..." />
                    </div>
                </div>
                <div class="col-7 ">
                    <button data-bs-target="#modal-tambah-satker" data-bs-toggle="modal" class="btn btn-primary float-md-end">Tambah</button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-lg">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Sub Unit Kerja</th>
                                                <th>Nama Ref Unit Kerja</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            <?php $id_ref_satker = ''; ?>
                                            <?php if ($list_subsatker != null) : ?>
                                                <?php foreach ($list_subsatker as $list) : ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><?= $list['nama_subsatker']; ?></td>
                                                        <td><?= $nama_satker; ?></td>
                                                        <td>
                                                            <button id="btn-edit-subsatker" data-bs-target="#modal-edit-satker" data-bs-toggle="modal" data-id="<?= $list['id'] ?>" data-nama-subsatker="<?= $list['nama_subsatker'] ?>" data-ref-subsatker="<?= $id_ref_satker ?>" class="btn btn-sm btn-outline-primary">
                                                                <i class="bi bi-pencil-fill"></i>
                                                            </button>
                                                            <button id="btn-hapus-subsatker" data-bs-target="#modal-hapus-subsatker" data-bs-toggle="modal" data-id="<?= $list['id']; ?>" data-nama-subsatker="<?= $list['nama_subsatker']; ?>" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                                        </td>
                                                    </tr>

                                                <?php endforeach; ?>
                                            <?php endif; ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>



<!-- MODAL TAMBAH-->
<div class="modal fade text-left modal-borderless" id="modal-tambah-satker" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable " role="document">
        <form action="<?= base_url('/tambahSubsatker'); ?>" method="post" class="modal-content" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Sub Unit Kerja</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group mb-4">
                    <label for="nama-satker" class="mb-2"><strong>Nama satker</strong></label>
                    <div class="form-group mb-4">
                        <input type="text" name="nama_satker" id="nama-satker" class="form-control" value="<?= $nama_satker; ?>" disabled>

                    </div>
                </div>
                <label for="nama-satker" class="mb-2"><strong>Nama Sub Unit Kerja</strong></label>
                <div class="form-group mb-4">
                    <input type="text" name="nama_subsatker" id="nama-satker" class="form-control" placeholder="Ketik Nama Sub Unit Kerja...">
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                    <span>Batal</span>
                </button>
                <button type="submit" class="btn btn-primary ml-1">
                    <span>Tambah</span>
                </button>
            </div>
        </form>
    </div>
</div>


<!-- MODAL EDIT-->
<div class="modal fade text-left modal-borderless" id="modal-edit-satker" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable " role="document">
        <form action="<?= base_url('/editSubsatker'); ?>" method="POST" class="modal-content">
            <input type="hidden" name="id_subsatker" id="id-subsatker-edit">
            <div class="modal-header">
                <h5 class="modal-title">Edit Sub Unit Kerja</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <label for="nama-satker" class="mb-2"><strong>Nama satker</strong></label>
                <div class="form-group mb-4">
                    <input type="text" name="nama_satker" id="nama-satker" class="form-control" value="<?= $nama_satker; ?>" disabled>

                </div>
                <label for="nama-satker-edit" class="mb-2"><strong>Nama Sub Unit Kerja</strong></label>
                <div class="form-group mb-4">
                    <input type="text" name="nama_subsatker" id="nama-satker-edit" class="form-control" placeholder="Ketik Nama Sub Unit Kerja...">
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                    <span>Batal</span>
                </button>
                <button type="submit" class="btn btn-primary ml-1">
                    <span>Update</span>
                </button>
            </div>
        </form>
    </div>
</div>


<!-- MODAL HAPUS-->
<div class="modal fade text-left modal-borderless" id="modal-hapus-subsatker" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable " role="document">
        <form action="<?= base_url('hapusSubsatker'); ?>" method="post" class="modal-content" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title text-danger"></h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body d-flex flex-column align-items-center py-0">
                <h6 class="mb-3">Hapus sub satker?</h6>
                <input name="id_subsatker_hapus" id="id-subsatker-hapus" class="d-none">
                <p class="text-center" style="font-size: 15px;">Apakah anda yakin menghapus sub satker <b id="nama-subsatker-hapus"></b>?<br>
                    Anda tidak dapat membatalkan tindakan ini!</p>

                <div class="d-flex  text-center border-danger  rounded-2" style="border-left: 2px solid red; width: 90%; background-color: #FFE8DB;">
                    <div class="text-center py-3" style="width: 15%; color: #A0443B; "><i class="bi bi-exclamation-triangle-fill"></i></div>
                    <div class="text-start py-3 px-2" style="width: 85%; font-size: 14px; color: red;">
                        <strong style="color: #A0443B; ">Peringatan!</strong>
                        <p class="mb-0">Dengan menghapus sub satker ini, memungkinkan terjadi terjadinya error pada ekspor laporan. <br> Diharapkan <b>periksa kembali</b> apakah data sub satker ini telah <b>digunakan</b> atau belum!</p>
                    </div>
                </div>
            </div>
            <div class="py-4 pb-5 text-center">
                <button type="button" style="width: 70px;" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <span>Batal</span>
                </button>
                <button type="submit" style="width: 70px;" class="btn btn-danger ml-1">
                    <span>Ya</span>
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>