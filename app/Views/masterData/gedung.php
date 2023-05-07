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
                        <input type="search" class="form-control" name="" id="" placeholder="Cari ..." />
                    </div>
                </div>
                <div class="col-7 ">
                    <button data-bs-target="#modal-tambah" data-bs-toggle="modal" class="btn btn-primary float-md-end">Tambah</button>
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
                                                <th>Fakultas</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Gege</td>
                                                <td>Mendalo</td>
                                                <td>Sains dan Teknologi</td>
                                                <td>
                                                    <button data-bs-target="#modal-tambah" data-bs-toggle="modal" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil-fill"></i></button>
                                                    <button data-bs-target="#modal-hapus" data-bs-toggle="modal" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                                </td>
                                            </tr>
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
<div class="modal fade text-left modal-borderless" id="modal-hapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable " role="document">
        <form action="" method="" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Hapus gedung?</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">

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
<div class="modal fade text-left modal-borderless" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable " role="document">
        <form action="" method="" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Gedung</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <label for="nama-gedung" class="mb-2"><strong>Nama Gedung</strong></label>
                <div class="form-group mb-4">
                    <input type="text" name="" id="nama-gedung" class="form-control" placeholder="Ketik nama gedung...">
                </div>

                <label for="lokasi" class="mb-2"><strong>Lokasi Kampus</strong></label>
                <fieldset class="form-group">
                    <select class="form-select" name="lokasi" id="lokasi">
                        <option disabled selected value="null">- Cari Kampus -</option>
                        <option value="1">Mendalo</option>
                        <option value="2">Pondok Meja</option>
                    </select>
                </fieldset>

                <label for="fakultas" class="mb-2"><strong>Fakultas</strong></label>
                <fieldset class="form-group">
                    <select class="form-select" name="fakultas">
                        <option disabled selected value="null">- Pilih Fakultas -</option>
                        <option value="1">Fakultas Sains dan Teknologi</option>
                        <option value="2">Fakultas Hukum</option>
                        <option value="3">Fakultas Pertanian</option>
                    </select>
                </fieldset>

                <label for="fakultas" class="mb-2"><strong>Status Gedung</strong></label>
                <fieldset class="form-group">
                    <select class="form-select" name="fakultas">
                        <option disabled selected value="null">- Status gedung -</option>
                        <option value="1">Runtuh</option>
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
<?= $this->endSection(); ?>