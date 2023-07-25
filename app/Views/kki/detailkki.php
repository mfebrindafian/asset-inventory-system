<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Detail KKI</h3>
            <p class="text-subtitle text-muted">Berikut merupakan detail dari KKI</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?= base_url('/list-kki') ?>">Import KKI</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail KKI</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-12">
            <div class="row mb-4">
                <div class="col-4">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-import">Update</button>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-hapus">Hapus</button>
                </div>
                <div class="col-3"></div>
                <div class="col-5">
                    <div class="form-group">
                        <input type="text" class="form-control" id="searchbar" placeholder="Cari ..." />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <p class="text-subtitle text-muted">Satker: <strong><?= $nama_satker; ?></strong></p>
                </div>
                <div class="col-6">
                    <p class="text-subtitle text-muted text-end">Kode Batch: <?= $kd_batch; ?></p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist ">
                                    <?php if ($data_bmn != null) : ?>
                                        <?php $ke = 0; ?>
                                        <?php foreach ($data_bmn as $bmn) : ?>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link <?php if ($ke == 0) {
                                                                        echo 'active';
                                                                    } ?>" id="<?= $bmn['uraian_akun']; ?>-tab" data-bs-toggle="tab" href="#<?= $bmn['uraian_akun']; ?>" role="tab" aria-controls="<?= $bmn['uraian_akun']; ?>" aria-selected="false"><?= $bmn['uraian_akun']; ?></a>
                                            </li>
                                            <?php $ke++ ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>

                                <div class="tab-content" id="myTabContent">
                                    <?php $ke2 = 0; ?>
                                    <?php if ($data_bmn != null) : ?>
                                        <?php foreach ($data_bmn as $bmn) : ?>

                                            <div class="tab-pane fade show <?php if ($ke2 == 0) {
                                                                                echo 'active';
                                                                            } ?>" id="<?= $bmn['uraian_akun']; ?>" role="tabpanel" aria-labelledby="<?= $bmn['uraian_akun']; ?>-tab">
                                                <!-- Table with outer spacing -->
                                                <div class="table-responsive">
                                                    <table class="table table-lg">
                                                        <thead>
                                                            <tr>
                                                                <th>No.</th>
                                                                <th>Kode Barang</th>
                                                                <th>Nama Barang</th>
                                                                <th>Tahun Perolehan</th>
                                                                <th>NUP</th>
                                                                <th>Merek</th>
                                                                <th>Kuantitas</th>
                                                                <th>Nilai BMN</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if ($bmn['data'] != null) : ?>
                                                                <?php $no = 1; ?>
                                                                <?php foreach ($bmn['data'] as $data) : ?>
                                                                    <?php if ($data['akun_id'] == $bmn['akun_id']) : ?>
                                                                        <tr>
                                                                            <td class="text-bold-500"><?= $no++; ?></td>
                                                                            <td><?= $data['kd_barang']; ?></td>
                                                                            <td class="text-bold-500"><?= $data['nama_barang']; ?></td>
                                                                            <td class="text-bold-500"><?= $data['thn_perolehan']; ?></td>
                                                                            <td class="text-bold-500"><?= $data['nup']; ?></td>
                                                                            <td class="text-bold-500"><?= $data['merk_tipe']; ?></td>
                                                                            <td class="text-bold-500"><?= $data['kuantitas']; ?></td>
                                                                            <td class="text-bold-500"><?= "Rp " . number_format($data['nilai_bmn'], 0, '', '.') ?></td>
                                                                        </tr>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                            <?php $ke2++ ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL -->
<div class="modal fade text-left modal-borderless" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <form action="<?= base_url('/import-update-kki'); ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="nama_satker" id="" value="<?= $nama_satker; ?>">
            <input type="hidden" name="kd_batch_update" id="" value="<?= $kd_batch; ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import KKI</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">Tambahkan data pada batch ini</p>
                    <input type="file" name="filekki" class="btn btn-primary w-100 py-4" accept=".xls, .xlsx" required />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                        <span>Batal</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1">
                        <span>Update</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- MODAL HAPUS-->
<div class="modal fade text-left modal-borderless" id="modal-hapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body d-flex justify-content-center">
                <div class="modal-body d-flex flex-column align-items-center py-0">
                    <h6 class="mb-3">Hapus Batch?</h6>
                    <p class="text-center" style="font-size: 15px;">Apakah anda yakin menghapus batch ini?<br>
                        Anda tidak dapat membatalkan tindakan ini!</p>

                    <div class="d-flex  text-center border-danger  rounded-2" style="border-left: 2px solid red; width: 90%; background-color: #FFE8DB;">
                        <div class="text-center py-3" style="width: 15%; color: #A0443B; "><i class="bi bi-exclamation-triangle-fill"></i></div>
                        <div class="text-start py-3 px-2" style="width: 85%; font-size: 14px; color: red;">
                            <strong style="color: #A0443B; ">Peringatan!</strong>
                            <p class="mb-0">Dengan menghapus batch ini, memungkinkan terjadi terjadinya error pada ekspor laporan. <br> Diharapkan <b>periksa kembali</b> data batch sebelum menghapus!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="py-4 pb-5 text-center">
                <button type="button" style="width: 70px;" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <span>Batal</span>
                </button>
                <a style="width: 70px;" href="<?= base_url('/hapus-batch/' . $kd_batch); ?>" class="btn btn-danger ml-1">
                    Hapus
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>