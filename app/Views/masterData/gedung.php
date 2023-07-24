<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Daftar Gedung</h3>
            <p class="text-subtitle text-muted">Berikut merupakan daftar Gedung di Universitas Jambi</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Gedung</li>
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
                    <button data-bs-target="#modal-tambah-gedung" data-bs-toggle="modal" class="btn btn-primary float-md-end">Tambah</button>
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
                                                <th>Nama Gedung</th>
                                                <th>Lokasi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; ?>
                                            <?php $id_lokasi = ''; ?>
                                            <?php if ($list_gedung != null) : ?>
                                                <?php foreach ($list_gedung as $list) : ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>
                                                        <td><?= $list['nama_gedung']; ?></td>
                                                        <td><?php if ($list_lokasi != null) : ?>
                                                                <?php foreach ($list_lokasi as $lokasi) : ?>
                                                                    <?php if ($lokasi['id'] == $list['id_lokasi']) {
                                                                        $id_lokasi = $lokasi['id'];
                                                                        echo $lokasi['nama_lokasi'];
                                                                    } ?>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?></td>
                                                        <td>
                                                            <button id="btn-edit-gedung" data-bs-target="#modal-edit-gedung" data-bs-toggle="modal" data-id="<?= $list['id'] ?>" data-nama-gedung="<?= $list['nama_gedung'] ?>" data-lokasi="<?= $id_lokasi; ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil-fill"></i></button>
                                                            <button data-bs-target="#modal-hapus-gedung" data-bs-toggle="modal" id="btn-hapus-gedung" data-id="<?= $list["id"] ?>" data-nama-gedung="<?= $list["nama_gedung"] ?>" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
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

<!-- MODAL HAPUS-->
<div class="modal fade text-left modal-borderless" id="modal-hapus-gedung" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable " role="document">
        <form action="<?= base_url('/hapusGedung'); ?>" method="post" class="modal-content" enctype="multipart/form-data">
            <!-- <input type="text" name="id_gedung_hapus" id="id-gedung-hapus" class="d-none"> -->
            <div class="modal-header">
                <h5 class="modal-title text-danger">Hapus gedung?</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body text-center">
                <input name="id_gedung_hapus" id="id-gedung-hapus" class="d-none">
                <h5 id="nama-gedung-hapus"></h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-danger" data-bs-dismiss="modal">
                    <span>Batal</span>
                </button>
                <button type="submit" class="btn btn-danger ml-1">
                    <span>Ya</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL TAMBAH-->
<div class="modal fade text-left modal-borderless" id="modal-tambah-gedung" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable " role="document">
        <form action="<?= base_url('/tambahGedung'); ?>" method="post" class="modal-content" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Gedung</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <label for="nama-gedung" class="mb-2"><strong>Nama Gedung</strong></label>
                <div class="form-group mb-4">
                    <input type="text" name="nama_gedung" id="nama-gedung" class="form-control" placeholder="Ketik nama gedung...">
                </div>

                <label for="lokasi" class="mb-2"><strong>Lokasi Gedung</strong></label>
                <fieldset class="form-group">
                    <select class="form-select" name="id_lokasi" id="lokasi">
                        <option disabled selected value="null">- Cari Lokasi -</option>
                        <?php if ($list_lokasi != null) : ?>
                            <?php foreach ($list_lokasi as $lokasi) : ?>
                                <option value="<?= $lokasi['id']; ?>"><?= $lokasi['nama_lokasi']; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </fieldset>
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
<div class="modal fade text-left modal-borderless" id="modal-edit-gedung" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable " role="document">
        <form action="" method="" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Gedung</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="id-gedung-edit">
                <label for="nama-gedung-edit" class="mb-2"><strong>Nama Gedung</strong></label>
                <div class="form-group mb-4">
                    <input type="text" name="" id="nama-gedung-edit" class="form-control" placeholder="Ketik nama gedung...">
                </div>

                <label for="lokasi-edit" class="mb-2"><strong>Lokasi Kampus</strong></label>
                <select class="form-select mb-4" name="lokasi" id="lokasi-edit">
                    <option disabled selected value="null">- Cari Lokasi -</option>
                    <?php if ($list_lokasi != null) : ?>
                        <?php foreach ($list_lokasi as $lokasi) : ?>
                            <option value="<?= $lokasi['id']; ?>"><?= $lokasi['nama_lokasi']; ?></option>
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


<?= $this->endSection(); ?>