<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<?php if (session('level_id') == 1 || session('level_id') == 2 || session('level_id') == 3 && $bmn['satker_id'] == session('satker_id')) : ?>
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Detail Barang</h3>
                <p class="text-subtitle text-muted">Berikut merupakan detail dari barang.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="listdetail.html">List Detail</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="page-content">
        <section class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="text-muted">Nama barang</p>
                                <h4 class="card-title"><?= $bmn['nama_barang']; ?></h4>

                                <span class="badge bg-light-primary"><?= $bmn['ur_akun']; ?></span>
                            </div>
                        </div>
                        <hr class="mb-0 mt-4" />
                    </div>

                    <div class="card-content">
                        <div class="card-body text-center text-sm-start">
                            <p class="text-muted">Detail</p>
                            <div class="row">
                                <div class="col-sm-4">
                                    <h6>Kode Barang</h6>
                                    <p class="text-muted"><?= $bmn['kd_barang']; ?></p>

                                    <h6>Tahun Perolehan</h6>
                                    <p class="text-muted"><?= $bmn['thn_perolehan']; ?></p>

                                    <h6>Nomor Urut Pendaftaran</h6>
                                    <p class="text-muted"><?= $bmn['nup']; ?></p>

                                    <h6>Merek/tipe</h6>
                                    <p class="text-muted"><?= $bmn['merk_tipe']; ?></p>

                                    <h6>Kuantitas</h6>
                                    <p class="text-muted"><?= $bmn['kuantitas']; ?></p>
                                </div>
                                <div class="col-sm-4">
                                    <h6>Nilai BMN</h6>
                                    <p class="text-muted">Rp. <?= $bmn['nilai_bmn']; ?></p>

                                    <h6>Kondisi Barang</h6>

                                    <p class="text-muted"><span class="badge  <?php if ($bmn['kondisi_brg'] == 'B') {
                                                                                    echo 'bg-light-success';
                                                                                } else if ($bmn['kondisi_brg'] == 'RR') {
                                                                                    echo 'bg-light-warning';
                                                                                } else if ($bmn['kondisi_brg'] == 'RB') {
                                                                                    echo 'bg-light-danger';
                                                                                } ?>"> <?php if ($bmn['kondisi_brg'] == 'B') {
                                                                                            echo 'Baik';
                                                                                        } else if ($bmn['kondisi_brg'] == 'RR') {
                                                                                            echo 'Rusak Ringan';
                                                                                        } else if ($bmn['kondisi_brg'] == 'RB') {
                                                                                            echo 'Rusak Berat';
                                                                                        } ?></span></p>

                                    <h6>Pelebelan Kodefikasi</h6>
                                    <p class="text-muted"><span class="badge  <?php if ($bmn['label_kode'] == 'S') {
                                                                                    echo 'bg-light-success';
                                                                                } else if ($bmn['label_kode'] == 'B') {
                                                                                    echo 'bg-light-danger';
                                                                                } ?>"><?php if ($bmn['label_kode'] == 'S') {
                                                                                            echo 'Sudah Dilabeli';
                                                                                        } else  if ($bmn['label_kode'] == 'B') {
                                                                                            echo 'Belum Dilabeli';
                                                                                        } ?></span></p>

                                    <h6>Keberadaan Barang</h6>
                                    <p class="text-muted"><span class="badge <?php if ($bmn['kbrdn_brg'] == 'BD') {
                                                                                    echo 'bg-light-success';
                                                                                } else if ($bmn['kbrdn_brg'] == 'BR') {
                                                                                    echo 'bg-light-warning';
                                                                                } else if ($bmn['kbrdn_brg'] == 'BTD') {
                                                                                    echo 'bg-light-danger';
                                                                                } ?>"><?php if ($bmn['kbrdn_brg'] == 'BD') {
                                                                                            echo 'Barang Ditemukan';
                                                                                        } else if ($bmn['kbrdn_brg'] == 'BR') {
                                                                                            echo 'Barang Berlebih';
                                                                                        } else if ($bmn['kbrdn_brg'] == 'BTD') {
                                                                                            echo 'Barang Tidak Diketemukan';
                                                                                        } ?></span></p>

                                    <h6>Nama Pegawai Pengguna Barang</h6>
                                    <p class="text-muted"><?= $bmn['pegawai_id']; ?></p>
                                </div>
                                <div class="col-sm-4">
                                    <h6>Nama Gedung</h6>
                                    <p class="text-muted"><?= $bmn['gedung_id']; ?></p>

                                    <h6>Nama Ruangan</h6>
                                    <p class="text-muted"><?= $bmn['ruangan_id']; ?></p>

                                    <h6>Status PSP</h6>
                                    <p class="text-muted"><span class="badge  <?php if ($bmn['label_kode'] == 'S') {
                                                                                    echo 'bg-light-success';
                                                                                } else if ($bmn['label_kode'] == 'B') {
                                                                                    echo 'bg-light-danger';
                                                                                } ?>"> <?php if ($bmn['label_kode'] == 'S') {
                                                                                            echo 'Sudah';
                                                                                        } else if ($bmn['label_kode'] == 'B') {
                                                                                            echo 'Belum';
                                                                                        } ?></span></p>

                                    <h6>Nama Sub Satuan Kerja</h6>
                                    <p class="text-muted"><?= $bmn['subsatker_id']; ?></p>

                                    <h6>Keterangan</h6>
                                    <p class="text-muted"><?= $bmn['ket']; ?></p>
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