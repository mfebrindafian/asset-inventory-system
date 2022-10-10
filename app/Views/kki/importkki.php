<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Import KKI</h3>
            <p class="text-subtitle text-muted">Lakukan import KKI dan lihat detail</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Import KKI</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-12">
            <div class="row">
                <div class="col-3 mb-4">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-import">Import</button>
                </div>
                <div class="col-3 col-md-5"></div>
                <div class="col-6 col-md-4">
                    <fieldset class="form-group">
                        <select class="form-select" id="basicSelect">
                            <option>- Satker -</option>
                            <option>Fakultas Sains dan Teknologi</option>
                            <option>Fakultas Hukum</option>
                            <option>Fakultas Peternakan</option>
                        </select>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="row px-4 py-4">
                            <div class="col-md-10">
                                <h4 class="card-title">Fakultas Sains Dan Teknologi</h4>
                                <span class="badge bg-light-primary">Jumlah data: 8.008</span>
                                <p class="text-muted mt-4 mb-0">Kode Batch: 02r3m93</p>
                            </div>
                            <div class="col-md-2 mt-3 mt-md-0 d-flex justify-content-end align-items-center">
                                <a href="<?= base_url('/detail-kki') ?>" class="btn btn-outline-primary">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="row px-4 py-4">
                            <div class="col-md-10">
                                <h4 class="card-title">Fakultas Hukum</h4>
                                <span class="badge bg-light-primary">Jumlah data: 208</span>
                                <p class="text-muted mt-4 mb-0">Kode Batch: 1n9ue1u</p>
                            </div>
                            <div class="col-md-2 mt-3 mt-md-0 d-flex justify-content-end align-items-center">
                                <a href="<?= base_url('/detail-kki') ?>" class="btn btn-outline-primary">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="row px-4 py-4">
                            <div class="col-md-10">
                                <h4 class="card-title">Fakultas Peternakan</h4>
                                <span class="badge bg-light-primary">Jumlah data: 1.180</span>
                                <p class="text-muted mt-4 mb-0">Kode Batch: r40j323</p>
                            </div>
                            <div class="col-md-2 mt-3 mt-md-0 d-flex justify-content-end align-items-center">
                                <a href="<?= base_url('/detail-kki') ?>" class="btn btn-outline-primary">Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <nav aria-label="Page navigation example">
                    <ul class="pagination pagination-primary justify-content-end">
                        <li class="page-item">
                            <a class="page-link" href="#">
                                <span aria-hidden="true"><i class="bi bi-chevron-left"></i></span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">
                                <span aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
</div>

<!-- MODAL -->
<div class="modal fade text-left modal-borderless" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
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
                            <option value="1">Fakultas Sains dan Teknologi</option>
                            <option value="2">Fakultas Hukum</option>
                            <option value="3">Fakultas Peternakan</option>
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
<?= $this->endSection(); ?>