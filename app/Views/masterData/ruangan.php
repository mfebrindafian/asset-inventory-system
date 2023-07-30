<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Daftar Ruangan</h3>
            <p class="text-subtitle text-muted">Berikut merupakan daftar ruangan di Universitas Jambi</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Ruangan</li>
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
                    <button data-bs-target="#modal-tambah-ruangan" data-bs-toggle="modal" class="btn btn-primary float-md-end">Tambah</button>
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
                                                <th>Nama Ruangan</th>
                                                <th>Kapasitas</th>
                                                <th>Gedung</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            <?php $id_gedung = '' ?>
                                            <?php if ($list_ruangan != null) : ?>
                                                <?php foreach ($list_ruangan as $list2) : ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><?= $list2['nama_ruang']; ?></td>
                                                        <td><?= $list2['kapasitas']; ?></td>
                                                        <td><?php if ($list_gedung != null) : ?>
                                                                <?php foreach ($list_gedung as $gedung) : ?>
                                                                    <?php if ($gedung['id'] == $list2['id_gedung']) {
                                                                        $id_gedung = $gedung['id'];
                                                                        echo $gedung['nama_gedung'];
                                                                    } ?>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?></td>
                                                        <td>
                                                            <button id="btn-edit-ruangan" data-bs-target="#modal-edit-ruangan" data-bs-toggle="modal" data-id="<?= $list2['id'] ?>" data-nama-ruangan="<?= $list2['nama_ruang'] ?>" data-kapasitas="<?= $list2['kapasitas'] ?>" data-pilih-gedung="<?= $id_gedung ?>" class="btn btn-sm btn-outline-primary">
                                                                <i class="bi bi-pencil-fill"></i>
                                                            </button>
                                                            <button id="btn-hapus-ruangan" data-bs-target="#modal-hapus-ruangan" data-bs-toggle="modal" data-id="<?= $list2["id"] ?>" data-nama-ruangan="<?= $list2["nama_ruang"] ?>"" class=" btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
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
<div class="modal fade text-left modal-borderless" id="modal-tambah-ruangan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable " role="document">
        <form action="<?= basename('/tambahRuangan'); ?>" method="post" class="modal-content" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Ruangan</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <label for="nama-satker" class="mb-2"><strong>Nama satker</strong></label>
                <div class="form-group mb-4">
                    <input type="text" name="nama_satker" id="nama-satker" class="form-control" value="<?= $nama_satker; ?>" disabled>

                </div>
                <label for="nama-ruangan" class="mb-2"><strong>Nama Ruangan</strong></label>
                <div class="form-group mb-4">
                    <input type="text" name="nama_ruangan" id="nama-ruangan" class="form-control" placeholder="Ketik Nama Ruangan...">
                </div>

                <label for="kapasitas" class="mb-2"><strong>Kapasitas</strong></label>
                <div class="form-group mb-4">
                    <input type="number" name="kapasitas" min="1" value="1" id="kapasitas" class="form-control" placeholder="Kapasitas Ruangan">
                </div>

                <label for="pilih-gedung" class="mb-2"><strong>Pilih Gedung</strong></label>
                <select class="form-select mb-4" name="id_gedung">
                    <option disabled selected value="null">- Pilih Gedung -</option>
                    <?php if ($list_gedung != null) : ?>
                        <?php foreach ($list_gedung as $gedung) : ?>
                            <option value="<?= $gedung['id']; ?>"><?= $gedung['nama_gedung']; ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
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
<div class="modal fade text-left modal-borderless" id="modal-edit-ruangan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable " role="document">
        <form action="<?= base_url('editRuangan'); ?>" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Ruangan</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_ruangan" id="id-ruangan-edit">

                <label for="nama-satker" class="mb-2"><strong>Nama satker</strong></label>
                <div class="form-group mb-4">
                    <input type="text" name="nama_satker" id="nama-satker" class="form-control" value="<?= $nama_satker; ?>" disabled>

                </div>

                <label for="nama-ruangan" class="mb-2"><strong>Nama Ruangan</strong></label>
                <div class="form-group mb-4">
                    <input type="text" name="nama_ruangan" id="nama-ruangan-edit" class="form-control" placeholder="Ketik Nama Ruangan...">
                </div>

                <label for="kapasitas" class="mb-2"><strong>Kapasitas</strong></label>
                <div class="form-group mb-4">
                    <input type="number" name="kapasitas" min="1" id="kapasitas-edit" class="form-control" placeholder="Kapasitas Ruangan">
                </div>

                <label for="pilih-gedung" class="mb-2"><strong>Pilih Gedung</strong></label>
                <select class="form-select mb-4" name="id_gedung" id="pilih-gedung-edit">
                    <option disabled selected value="null">- Pilih Gedung -</option>
                    <?php if ($list_gedung != null) : ?>
                        <?php foreach ($list_gedung as $gedung) : ?>
                            <option value="<?= $gedung['id']; ?>"><?= $gedung['nama_gedung']; ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>

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
<div class="modal fade text-left modal-borderless" id="modal-hapus-ruangan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable " role="document">
        <form action="<?= base_url('/hapusRuangan'); ?>" method="post" class="modal-content" enctype="multipart/form-data">
            <!-- <input type="text" name="id_ruangan_hapus" id="id-ruangan-hapus" class="d-none"> -->
            <div class="modal-header">
                <h5 class="modal-title text-danger"></h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body d-flex flex-column align-items-center py-0">
                <h6 class="mb-3">Hapus ruangan?</h6>
                <input name="id_ruangan_hapus" id="id-ruangan-hapus" class="d-none">
                <p class="text-center" style="font-size: 15px;">Apakah anda yakin menghapus ruangan <b id="nama-ruangan-hapus"></b>?<br>
                    Anda tidak dapat membatalkan tindakan ini!</p>

                <div class="d-flex  text-center border-danger  rounded-2" style="border-left: 2px solid red; width: 90%; background-color: #FFE8DB;">
                    <div class="text-center py-3" style="width: 15%; color: #A0443B; "><i class="bi bi-exclamation-triangle-fill"></i></div>
                    <div class="text-start py-3 px-2" style="width: 85%; font-size: 14px; color: red;">
                        <strong style="color: #A0443B; ">Peringatan!</strong>
                        <p class="mb-0">Dengan menghapus ruangan ini, memungkinkan terjadi terjadinya error pada ekspor laporan. <br> Diharapkan <b>periksa kembali</b> apakah data ruangan ini telah <b>digunakan</b> atau belum!</p>
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