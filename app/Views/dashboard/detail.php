<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
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
                                <p class="text-muted"><span class="badge bg-light-warning"><?= $bmn['kondisi_brg']; ?></span></p>

                                <h6>Pelebelan Kodefikasi</h6>
                                <p class="text-muted"><span class="badge bg-light-danger"><?= $bmn['label_kode']; ?></span></p>

                                <h6>Keberadaan Barang</h6>
                                <p class="text-muted"><span class="badge bg-light-success"><?= $bmn['kbrdn_brg']; ?></span></p>

                                <h6>Nama Pegawai Pengguna Barang</h6>
                                <p class="text-muted"><?= $bmn['pegawai_id']; ?></p>
                            </div>
                            <div class="col-sm-4">
                                <h6>Nama Gedung</h6>
                                <p class="text-muted"><?= $bmn['gedung_id']; ?></p>

                                <h6>Nama Ruangan</h6>
                                <p class="text-muted"><?= $bmn['ruangan_id']; ?></p>

                                <h6>Status PSP</h6>
                                <p class="text-muted"><span class="badge bg-light-success"><?= $bmn['status_psp']; ?></span></p>

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
<?= $this->endSection(); ?>