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
                        <input type="search" class="form-control" name="" id="" placeholder="Cari ..." />
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
                                            <tr>
                                                <td>1</td>
                                                <td>Kemahasiswaan</td>
                                                <td>Akademik dan Kemahasiswaan</td>
                                                <td>
                                                    <button id="btn-edit-satker" data-bs-target="#modal-edit-satker" data-bs-toggle="modal" data-id="1" data-nama-satker="Kemahasiswaan" data-ref-satker="1" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil-fill"></i>
                                                    </button>
                                                    <button id="btn-hapus-satker" data-bs-target="#modal-hapus-satker" data-bs-toggle="modal" data-id="1" data-nama-satker="Kemahasiswaan" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
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



<!-- MODAL TAMBAH-->
<div class="modal fade text-left modal-borderless" id="modal-tambah-satker" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable " role="document">
        <form action="" method="" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Sub Unit Kerja</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <label for="nama-satker" class="mb-2"><strong>Nama Sub Unit Kerja</strong></label>
                <div class="form-group mb-4">
                    <input type="text" name="nama_satker" id="nama-satker" class="form-control" placeholder="Ketik Nama Sub Unit Kerja...">
                </div>

                <label for="pilih-ref-satker" class="mb-2"><strong>Pilih Ref Satuan Unit Kerja</strong></label>
                <select class="form-select mb-4" name="ref-satker">
                    <option disabled selected value="null">- Pilih Ref Satuan Unit Kerja -</option>
                    <option value="1">Fakultas Sains dan Teknologi</option>
                    <option value="2">Fakultas Hukum</option>
                    <option value="3">Fakultas Pertanian</option>
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
<div class="modal fade text-left modal-borderless" id="modal-edit-satker" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable " role="document">
        <form action="" method="" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Sub Unit Kerja</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="id-satker-edit">
                <label for="nama-satker-edit" class="mb-2"><strong>Nama Sub Unit Kerja</strong></label>
                <div class="form-group mb-4">
                    <input type="text" name="nama_satker" id="nama-satker-edit" class="form-control" placeholder="Ketik Nama Sub Unit Kerja...">
                </div>

                <label for="pilih-ref-satker-edit" class="mb-2"><strong>Pilih Ref Satuan Unit Kerja</strong></label>
                <select class="form-select mb-4" name="ref_satker" id="pilih-ref-satker-edit">
                    <option disabled selected value="null">- Pilih Ref Satuan Unit Kerja -</option>
                    <option value="1">Fakultas Sains dan Teknologi</option>
                    <option value="2">Fakultas Hukum</option>
                    <option value="3">Fakultas Pertanian</option>
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
<div class="modal fade text-left modal-borderless" id="modal-hapus-satker" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable " role="document">
        <form action="" method="" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Hapus Sub Unit Kerja?</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body text-center">
                <input type="hidden" name="id_satker_hapus" id="id-satker-hapus">
                <h5 id="nama-satker-hapus"></h5>
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
<?= $this->endSection(); ?>