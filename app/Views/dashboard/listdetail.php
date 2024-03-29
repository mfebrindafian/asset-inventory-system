<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<?php if (session('level_id') == 1 || session('level_id') == 2 || session('level_id') == 3 && $satker_id == session('satker_id')) : ?>
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>PM NON TIK</h3>
                <p class="text-subtitle text-muted">Berikut merupakan daftar Peralatan Mesin NON TIK yang belum diproses</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.html">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">List Detail</li>
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
                            <input type="text" class="form-control" id="searchbar" placeholder="Cari ..." />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
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
                                                    <th>Kuantitas</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $ke = 1 ?>
                                                <?php if ($list_bmn != null) : ?>
                                                    <?php foreach ($list_bmn as $bmn) : ?>
                                                        <tr>
                                                            <td class="text-bold-500"><?= $ke++; ?></td>
                                                            <td><?= $bmn['kd_barang']; ?></td>
                                                            <td class="text-bold-500"><?= $bmn['nama_barang']; ?></td>
                                                            <td class="text-bold-500"><?= $bmn['thn_perolehan']; ?></td>
                                                            <td class="text-bold-500"><?= $bmn['nup']; ?></td>
                                                            <td class="text-bold-500"><?= $bmn['kuantitas']; ?></td>
                                                            <td class="text-bold-500"><span class="badge <?php if ($bmn['kondisi_brg'] == null) {
                                                                                                                echo 'bg-light-danger';
                                                                                                            } else {
                                                                                                                echo 'bg-light-success';
                                                                                                            } ?>"><?php if ($bmn['kondisi_brg'] == null) {
                                                                                                                        echo 'belum';
                                                                                                                    } else {
                                                                                                                        echo 'sudah';
                                                                                                                    } ?> diproses</span></td>
                                                            <td class="text-bold-500"><a href="<?= base_url('/detail-bmn-dashboard/' . $bmn['id']) ?>" class="btn btn-sm btn-primary">Detail</a></td>
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
<?php endif; ?>
<?= $this->endSection(); ?>