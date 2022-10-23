<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Dashboard</h3>
            <p class="text-subtitle text-muted">Rekap data inventarisasi barang milik negara pada Universitas Jambi <span class="satker-apa"></span></p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-12">
            <div class="row">
                <div class="col-8"></div>
                <div class="col-6 col-sm-4 float-end">
                    <fieldset class="form-group">
                        <select class="form-select" id="pilihSatker">
                            <option disabled selected>- Satker -</option>
                            <option value="all">Semua</option>
                            <?php if ($list_satker != null) : ?>
                                <?php foreach ($list_satker as $satker) : ?>
                                    <option value="<?= $satker['id']; ?>"> <a href="/aa"><?= $satker['nama_satker']; ?></a></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <?php $ke = 1; ?>
                <?php if ($list_akun != null) : ?>
                    <?php foreach ($list_akun as $akun) : ?>

                        <div class="col-12 col-lg-6 col-md-12">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="text-muted">Unit Satker: <span class="font-bold satker-apa"></span></p>
                                            <p class="text-muted">Total barang: <span class="font-bold all"><?= $data_bmn['all'][$ke]; ?></span></p>
                                        </div>
                                        <div class="col-6">
                                            <div class="float-end">
                                                <h3 class="text-end"><?= $akun['ur_akun']; ?></h3>
                                                <p class="text-muted text-end"><?= $akun['ket_akun']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <a href="<?= base_url('/list-bmn-dashboard/sudah/' . $akun['id'] . '/' . $nama_satker) ?>" class="badge bg-light-success pt-3 w-100">
                                                <h6 class="text-wrap">Sudah diproses</h6>
                                                <h1 class="my-4 sudah text-truncate"><?= $data_bmn['sudah'][$ke]; ?></h1>
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <a href="<?= base_url('/list-bmn-dashboard/belum/' . $akun['id'] . '/' . $nama_satker) ?>" class="badge bg-light-danger pt-3 w-100">
                                                <h6 class="text-wrap">Belum diproses</h6>
                                                <h1 class="my-4 belum text-truncate"><?= $data_bmn['belum'][$ke]; ?></h1>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <a href="<?= base_url('/list-bmn-dashboard/semua/' . $akun['id'] . '/' . $nama_satker) ?>" class="btn btn-outline-primary w-100">Detail</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $ke++ ?>
                    <?php endforeach; ?>
                <?php endif ?>
            </div>
    </section>
</div>
<?= $this->endSection(); ?>