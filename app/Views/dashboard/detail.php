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
                            <h4 class="card-title">Uninterruptible Power Supply (UPS)</h4>

                            <span class="badge bg-light-primary">PM NON TIK</span>
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
                                <p class="text-muted">3060101048</p>

                                <h6>Tahun Perolehan</h6>
                                <p class="text-muted">2019</p>

                                <h6>Nomor Urut Pendaftaran</h6>
                                <p class="text-muted">1</p>

                                <h6>Merek/tipe</h6>
                                <p class="text-muted">UPS 602B</p>

                                <h6>Kuantitas</h6>
                                <p class="text-muted">10</p>
                            </div>
                            <div class="col-sm-4">
                                <h6>Nilai BMN</h6>
                                <p class="text-muted">Rp. 3.355.000</p>

                                <h6>Kondisi Barang</h6>
                                <p class="text-muted"><span class="badge bg-light-warning">Rusak Ringan</span></p>

                                <h6>Pelebelan Kodefikasi</h6>
                                <p class="text-muted"><span class="badge bg-light-danger">Belum Dilabeli</span></p>

                                <h6>Keberadaan Barang</h6>
                                <p class="text-muted"><span class="badge bg-light-success">Barang Ditemukan</span></p>

                                <h6>Nama Pegawai Pengguna Barang</h6>
                                <p class="text-muted">Budiman</p>
                            </div>
                            <div class="col-sm-4">
                                <h6>Nama Gedung</h6>
                                <p class="text-muted">Fakultas Sains dan Teknologi</p>

                                <h6>Nama Ruangan</h6>
                                <p class="text-muted">Lab ICT 001</p>

                                <h6>Status PSP</h6>
                                <p class="text-muted"><span class="badge bg-light-success">Sudah</span></p>

                                <h6>Nama Sub Satuan Kerja</h6>
                                <p class="text-muted">Tata Usaha</p>

                                <h6>Keterangan</h6>
                                <p class="text-muted">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ut provident vel magni, fuga nulla nihil!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>