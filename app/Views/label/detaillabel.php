<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<style>
    td,
    th {
        border: 1px solid black;
        padding: 8px 10px 8px 10px;
    }
</style>

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
                                <?php if ($bmn['kbrdn_brg'] == 'BTD') : ?>
                                    <h6>Kategori Barang Tidak Ditemukan</h6>
                                    <p class="text-muted"><span class="badge bg-light-danger"><?php if ($bmn['kategori_btd'] == '1') {
                                                                                                    echo 'Hilang';
                                                                                                } else if ($bmn['kategori_btd'] == '2') {
                                                                                                    echo 'Salah kodefikasi';
                                                                                                } else if ($bmn['kategori_btd'] == '3') {
                                                                                                    echo 'Pekerjaan renovasi/pengembangan dicatat sebagai NUP baru';
                                                                                                } else if ($bmn['kategori_btd'] == '4') {
                                                                                                    echo 'pencatatatan ganda/ fiktif';
                                                                                                } ?></span></p>
                                <?php endif; ?>

                                <?php if ($bmn['kbrdn_brg'] == 'BR') : ?>
                                    <h6>Kategori Berlebih</h6>
                                    <p class="text-muted"><span class="badge bg-light-warning"><?php if ($bmn['kategori_br'] == '1') {
                                                                                                    echo 'Belum tercatat dalam laporan BMN';
                                                                                                } else if ($bmn['kategori_br'] == '2') {
                                                                                                    echo 'Salah kodefikasi';
                                                                                                } else if ($bmn['kategori_br'] == '3') {
                                                                                                    echo 'Pencatatan gelondongan';
                                                                                                } ?></span></p>
                                <?php endif; ?>


                            </div>
                            <div class="col-sm-4">
                                <h6>Nama Pegawai Pengguna Barang</h6>
                                <p class="text-muted">
                                    <?php if ($list_pegawai != null) : ?>
                                        <?php foreach ($list_pegawai as $pegawai) : ?>
                                            <?php if ($bmn['pegawai_id'] == $pegawai['id_pegawai']) : ?>
                                                <?php
                                                $nama_pegawai = $pegawai['gelar_depan'];
                                                if ($pegawai['gelar_depan'] != null) {
                                                    $nama_pegawai .= ' ';
                                                }
                                                $nama_pegawai .= $pegawai['nama_pegawai'];
                                                if ($pegawai['gelar_belakang'] != null) {
                                                    $nama_pegawai .= ' ';
                                                }
                                                $nama_pegawai .= $pegawai['gelar_belakang']; ?>
                                                <?= $nama_pegawai; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </p>
                                <h6>Nama Gedung</h6>
                                <p class="text-muted"><?php if ($list_gedung != null) : ?>
                                        <?php foreach ($list_gedung as $gedung) : ?>
                                            <?php if ($bmn['gedung_id'] == $gedung['id']) : ?>

                                                <?= $gedung['nama_gedung']; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?></p>

                                <h6>Nama Ruangan</h6>
                                <p class="text-muted"><?php if ($list_ruangan != null) : ?>
                                        <?php foreach ($list_ruangan as $ruangan) : ?>
                                            <?php if ($bmn['ruangan_id'] == $ruangan['id']) : ?>

                                                <?= $ruangan['nama_ruang']; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?></p>

                                <h6>Status PSP</h6>
                                <p class="text-muted"><span class="badge  <?php if ($bmn['status_psp'] == 'S') {
                                                                                echo 'bg-light-success';
                                                                            } else if ($bmn['status_psp'] == 'B') {
                                                                                echo 'bg-light-danger';
                                                                            } ?>"> <?php if ($bmn['status_psp'] == 'S') {
                                                                                        echo 'Sudah';
                                                                                    } else if ($bmn['status_psp'] == 'B') {
                                                                                        echo 'Belum';
                                                                                    } ?></span></p>

                                <h6>Nama Sub Satuan Kerja</h6>
                                <p class="text-muted"><?php if ($list_subsatker != null) : ?>
                                        <?php foreach ($list_subsatker as $subsatker) : ?>
                                            <?php if ($bmn['subsatker_id'] == $subsatker['id']) : ?>

                                                <?= $subsatker['nama_subsatker']; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?></p>

                                <h6>Keterangan</h6>
                                <p class="text-muted"><?= $bmn['ket'] == '' ? '-' : $bmn['ket']; ?></p>
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
                <table id="label" class=" mb-0 border-0" style="width: 550px; min-width: 550px; border: 1px solid black;">
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
                            <td class="text-center">UNJA-023.17.1000.677565.<?= $bmn['satker_id']; ?> <?= $bmn['kd_barang']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">LABEL SEMENTARA INVENTARISASI <?= $bmn['thn_perolehan']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-sm">
                                <span class="text-left">Fakultas: <?= $nama_satker; ?></span>
                                <span class="float-end"><?= $bmn['ur_akun']; ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-sm">No. Urut Inventarisasi BMN: <?= $bmn['nup']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                    <span>Batal</span>
                </button>
                <button type="submit" id="cetak" class="btn btn-primary ml-1">
                    <span>Cetak</span>
                </button>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>