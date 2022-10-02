<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Cetak Label</h3>
            <p class="text-subtitle text-muted">Anda dapat mencetak dan mengupdate label.</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cetak Label</li>
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
                            <span class="badge bg-light-danger float-start">Belum Dilabeli</span>
                            <span class="badge bg-light-primary mx-2">PM NON TIK</span>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-3 mt-md-0 float-md-end">
                                <button class="btn btn-outline-primary">Update Status Labelisasi</button>
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-cetak">Cetak Label</button>
                            </div>
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

                                <h6>Keberadaan Barang</h6>
                                <p class="text-muted"><span class="badge bg-light-success">Barang Ditemukan</span></p>

                                <h6>Nama Pegawai Pengguna Barang</h6>
                                <p class="text-muted">Budiman</p>

                                <h6>Nama Gedung</h6>
                                <p class="text-muted">Fakultas Sains dan Teknologi</p>
                            </div>
                            <div class="col-sm-4">
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

<!-- MODAL -->
<div class="modal fade text-left modal-borderless" id="modal-cetak" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cetak Label</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body d-flex justify-content-center">
                <table class="table table-bordered mb-0" style="width: 550px; min-width: 550px">
                    <thead>
                        <tr>
                            <th colspan="2" class="text-center">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET DAN TEKNOLOGI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="5" class="text-center"><img src="assets/images/logo-unja.png" alt="logo unja" width="140" /></td>
                        </tr>
                        <tr>
                            <td class="text-center">UNJA-023.17.1000.677565</td>
                        </tr>
                        <tr>
                            <td class="text-center">LABEL SEMENTARA INVENTARISASI 2022-2023</td>
                        </tr>
                        <tr>
                            <td class="text-sm">
                                <span class="text-left">Fakultas: Sains dan Teknologi</span>
                                <span class="float-end">PM NON TIK</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm">No. Urut Inventarisasi BMN: 44</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                    <span>Batal</span>
                </button>
                <button type="submit" class="btn btn-primary ml-1">
                    <span>Cetak</span>
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>