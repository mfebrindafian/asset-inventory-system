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
                            <h4 class="card-title"><?= $bmn['nama_barang']; ?></h4>
                            <span class="badge  <?php if ($bmn['label_kode'] == null || $bmn['label_kode'] == 'B') {
                                                    echo 'bg-light-danger';
                                                } else {
                                                    echo 'bg-light-success';
                                                } ?> float-start"><?php if ($bmn['label_kode'] == null || $bmn['label_kode'] == 'B') {
                                                                        echo 'Belum';
                                                                    } else {
                                                                        echo 'Sudah';
                                                                    } ?> Dilabeli</span>
                            <span class="badge bg-light-primary mx-2"><?= $bmn['ur_akun']; ?></span>
                        </div>
                        <div class="col-md-6">
                            <div class="mt-3 mt-md-0 float-md-end">
                                <a href="<?= base_url('/updateStatusLabel/' . $bmn['id']); ?>" class="btn btn-outline-primary">Update Status Labelisasi</a>
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
                                                                            } else {
                                                                                echo 'bg-light-danger';
                                                                            } ?>"> <?php if ($bmn['kondisi_brg'] == 'B') {
                                                                                        echo 'Baik';
                                                                                    } else if ($bmn['kondisi_brg'] == 'RR') {
                                                                                        echo 'Rusak Ringan';
                                                                                    } else {
                                                                                        echo 'Rusak Berat';
                                                                                    } ?></span></p>

                                <h6>Pelebelan Kodefikasi</h6>
                                <p class="text-muted"><span class="badge  <?php if ($bmn['label_kode'] == 'S') {
                                                                                echo 'bg-light-success';
                                                                            } else {
                                                                                echo 'bg-light-danger';
                                                                            } ?>"><?php if ($bmn['label_kode'] == 'S') {
                                                                                        echo 'Sudah Dilabeli';
                                                                                    } else {
                                                                                        echo 'Belum Dilabeli';
                                                                                    } ?></span></p>

                                <h6>Keberadaan Barang</h6>
                                <p class="text-muted"><span class="badge <?php if ($bmn['kbrdn_brg'] == 'BD') {
                                                                                echo 'bg-light-success';
                                                                            } else if ($bmn['kbrdn_brg'] == 'BR') {
                                                                                echo 'bg-light-warning';
                                                                            } else {
                                                                                echo 'bg-light-danger';
                                                                            } ?>"><?php if ($bmn['kbrdn_brg'] == 'BD') {
                                                                                        echo 'Barang Ditemukan';
                                                                                    } else if ($bmn['kbrdn_brg'] == 'BR') {
                                                                                        echo 'Barang Berlebih';
                                                                                    } else {
                                                                                        echo 'Barang Tidak Ditemukan';
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
                                <p class="text-muted"><span class="badge  <?php if ($bmn['status_psp'] == 'S') {
                                                                                echo 'bg-light-success';
                                                                            } else {
                                                                                echo 'bg-light-danger';
                                                                            } ?>"> <?php if ($bmn['status_psp'] == 'S') {
                                                                                        echo 'Sudah';
                                                                                    } else {
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
                            <td rowspan="5" class="text-center"><img src="/assets/images/logo-unja.png" alt="logo unja" width="140" /></td>
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