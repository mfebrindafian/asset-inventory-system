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
                        <select class="form-select" name="satker" id="pilih-satker">
                            <option selected value="null">- Semua Satker -</option>
                            <?php if ($list_satker != null) : ?>
                                <?php foreach ($list_satker as $satker) : ?>
                                    <option value="<?= $satker['id_ref_unit_kerja']; ?>"><?= $satker['nama_ref_unit_kerja_lengkap']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </select>
                    </fieldset>
                </div>
            </div>
            <div class="row" id="listKki">
            </div>
            <?= $this->include('layout/loader') ?>

            <div id="empty" style="display: none; font-size: larger;" class="w-100 text-center">
                <span> Maaf, data tidak tersedia</span>
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
                    <div class="form-group mb-4">
                        <label for="satker-kki" class="mb-2"><strong>Pilih Unit Kerja</strong> </label>
                        <select class="form-select select-satker2" name="satker" id="satker-kki" required>
                            <option>- Unit Kerja -</option>
                            <?php if ($list_satker != null) : ?>
                                <?php foreach ($list_satker as $satker) : ?>
                                    <option value="<?= $satker['id_ref_unit_kerja']; ?>"><?= $satker['nama_ref_unit_kerja_lengkap']; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <input type="file" name="filekki" class="btn btn-primary w-100 py-4" accept=".xls, .xlsx" required />
                </div>
                <div class="modal-footer d-flex justify-content-between mt-3">
                    <a href="<?= basename('/unduh-Template-Import'); ?>">
                        Unduh Template
                    </a>
                    <div>
                        <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                            <span>Batal</span>
                        </button>
                        <button type="submit" id="btn-submit" disabled class="btn btn-primary ml-1 ">
                            <span>Import</span>
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>