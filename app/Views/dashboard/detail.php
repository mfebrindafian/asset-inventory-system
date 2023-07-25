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
                                    <p class="text-muted"><?= "Rp " . number_format($bmn['nilai_bmn'], 0, '', '.') ?></p>

                                    <h6>Kondisi Barang</h6>

                                    <p class="text-muted"><span class=" <?php if ($bmn['kondisi_brg'] == 'B') {
                                                                            echo 'badge bg-light-success';
                                                                        } else if ($bmn['kondisi_brg'] == 'RR') {
                                                                            echo 'badge bg-light-warning';
                                                                        } else if ($bmn['kondisi_brg'] == 'RB') {
                                                                            echo 'badge bg-light-danger';
                                                                        } ?>"> <?php if ($bmn['kondisi_brg'] == 'B') {
                                                                                    echo 'Baik';
                                                                                } else if ($bmn['kondisi_brg'] == 'RR') {
                                                                                    echo 'Rusak Ringan';
                                                                                } else if ($bmn['kondisi_brg'] == 'RB') {
                                                                                    echo 'Rusak Berat';
                                                                                } else {
                                                                                    echo '-';
                                                                                } ?></span></p>

                                    <h6>Pelebelan Kodefikasi</h6>
                                    <p class="text-muted"><span class="  <?php if ($bmn['label_kode'] == 'S') {
                                                                                echo 'badge bg-light-success';
                                                                            } else if ($bmn['label_kode'] == 'B') {
                                                                                echo 'badge bg-light-danger';
                                                                            } ?>"><?php if ($bmn['label_kode'] == 'S') {
                                                                                        echo 'Sudah Dilabeli';
                                                                                    } else  if ($bmn['label_kode'] == 'B') {
                                                                                        echo 'Belum Dilabeli';
                                                                                    } else {
                                                                                        echo '-';
                                                                                    } ?></span></p>

                                    <h6>Keberadaan Barang</h6>
                                    <p class="text-muted"><span class="<?php if ($bmn['kbrdn_brg'] == 'BD') {
                                                                            echo 'badge bg-light-success';
                                                                        } else if ($bmn['kbrdn_brg'] == 'BR') {
                                                                            echo 'badge bg-light-warning';
                                                                        } else if ($bmn['kbrdn_brg'] == 'BTD') {
                                                                            echo 'badge bg-light-danger';
                                                                        } ?>"><?php if ($bmn['kbrdn_brg'] == 'BD') {
                                                                                    echo 'Barang Ditemukan';
                                                                                } else if ($bmn['kbrdn_brg'] == 'BR') {
                                                                                    echo 'Barang Berlebih';
                                                                                } else if ($bmn['kbrdn_brg'] == 'BTD') {
                                                                                    echo 'Barang Tidak Diketemukan';
                                                                                } else {
                                                                                    echo '-';
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
                                                <?php else : ?>
                                                    <?= '-';
                                                    break; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>

                                        <?php endif; ?>
                                    </p>
                                    <h6>Nama Gedung</h6>
                                    <p class="text-muted"><?php if ($list_gedung != null) : ?>
                                            <?php foreach ($list_gedung as $gedung) : ?>
                                                <?php if ($bmn['gedung_id'] == $gedung['id']) : ?>

                                                    <?= $gedung['nama_gedung']; ?>
                                                <?php else : ?>
                                                    <?= '-' ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?></p>

                                    <h6>Nama Ruangan</h6>
                                    <p class="text-muted"><?php if ($list_ruangan != null) : ?>
                                            <?php foreach ($list_ruangan as $ruangan) : ?>
                                                <?php if ($bmn['ruangan_id'] == $ruangan['id']) : ?>

                                                    <?= $ruangan['nama_ruang']; ?>
                                                <?php else : ?>
                                                    <?= '-' ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endif; ?></p>

                                    <h6>Status PSP</h6>
                                    <p class="text-muted"><span class=" <?php if ($bmn['status_psp'] == 'S') {
                                                                            echo 'badge bg-light-success';
                                                                        } else if ($bmn['status_psp'] == 'B') {
                                                                            echo 'badge bg-light-danger';
                                                                        } ?>"> <?php if ($bmn['status_psp'] == 'S') {
                                                                                    echo 'Sudah';
                                                                                } else if ($bmn['status_psp'] == 'B') {
                                                                                    echo 'Belum';
                                                                                } else if ($bmn['status_psp'] == null) {
                                                                                    echo '-';
                                                                                } ?></span></p>
                                    <h6>Nama Sub Satuan Kerja</h6>
                                    <p class="text-muted">
                                        <?php if ($list_subsatker != null) : ?>
                                            <?php foreach ($list_subsatker as $subsatker) : ?>
                                                <?php if ($bmn['subsatker_id'] == $subsatker['id']) : ?>
                                                    <?= $subsatker['nama_subsatker']; ?>
                                                <?php else : ?>
                                                    <?= '-' ?>
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
<?php endif; ?>
<?= $this->endSection(); ?>