<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<?php if ($bmn != null) : ?>
    <?php if ($bmn['satker_id'] == session('satker_id')) : ?>
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Isi Kertas Kerja</h3>
                    <p class="text-subtitle text-muted">Silahkan isi data di bawah ini</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Isi Kertas Kerja</li>
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
                                    <span>Nama Unit Satker: <?= $nama_satker; ?></span>
                                </div>
                                <div class="col-md-6 d-none d-md-block">
                                    <a class="float-end text-lg" data-bs-toggle="collapse" href="#detailCollapse" role="button" aria-expanded="true" aria-controls="detailCollapse"><i class="bi bi-dash-lg"></i></a>
                                </div>
                            </div>
                            <hr class="mb-0 mt-4" />
                        </div>

                        <div class="card-content">
                            <div class="card-body text-center text-sm-start">
                                <div class="row collapse show" id="detailCollapse">
                                    <p class="text-muted">Detail</p>
                                    <div class="col-sm-4">
                                        <h6>Kode Barang</h6>
                                        <p class="text-muted"><?= $bmn['kd_barang']; ?></p>

                                        <h6>Tahun Perolehan</h6>
                                        <p class="text-muted"><?= $bmn['thn_perolehan']; ?></p>
                                    </div>
                                    <div class="col-sm-4">
                                        <h6>Nomor Urut Pendaftaran</h6>
                                        <p class="text-muted"><?= $bmn['nup']; ?></p>

                                        <h6>Merek/tipe</h6>
                                        <p class="text-muted"><?= $bmn['merk_tipe']; ?></p>
                                    </div>
                                    <div class="col-sm-4">
                                        <h6>Kuantitas</h6>
                                        <p class="text-muted"><?= $bmn['kuantitas']; ?></p>

                                        <h6>Nilai BMN</h6>
                                        <p class="text-muted"><?= "Rp " . number_format($bmn['nilai_bmn'], 0, '', '.') ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="text-muted">Isi Data</p>
                                    <h4 class="card-title"><?= $bmn['nama_barang']; ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="errorlist">
                            <div id="errorContainer" style="display: none;"></div>
                        </div>
                        <div class="card-content">
                            <form id="kertas-kerja" action="<?= base_url('/isikertaskerja-add'); ?>" method="post" class="card-body" enctype="multipart/form-data">
                                <input type="hidden" name="id_bmn" value="<?= $bmn['id']; ?>">
                                <input type="hidden" name="tipe_akun" value="<?= $bmn['ur_akun'];  ?>">

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="mb-5">
                                            <h6>Kondisi Barang <span class="text-danger text-sm" style="font-weight: 400;">* wajib diisi</span></h6>
                                            <input type="radio" class="btn-check" name="kondisi-barang" id="baik" value="B" <?php if ($bmn['kondisi_brg'] == 'B') {
                                                                                                                                echo 'checked';
                                                                                                                            } ?> autocomplete="off" />
                                            <label class="btn btn-sm btn-outline-success" for="baik">Baik</label>

                                            <input type="radio" class="btn-check" name="kondisi-barang" id="rusak-ringan" value="RR" <?php if ($bmn['kondisi_brg'] == 'RR') {
                                                                                                                                            echo 'checked';
                                                                                                                                        } ?> autocomplete="off" />
                                            <label class="btn btn-sm btn-outline-warning" for="rusak-ringan">Rusak Ringan</label>

                                            <input type="radio" class="btn-check" name="kondisi-barang" id="rusak-berat" value="RB" <?php if ($bmn['kondisi_brg'] == 'RB') {
                                                                                                                                        echo 'checked';
                                                                                                                                    } ?> autocomplete="off" />
                                            <label class="btn btn-sm btn-outline-danger" for="rusak-berat">Rusak Berat</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-5">
                                            <h6>Keberadaan Barang <span class="text-danger text-sm" style="font-weight: 400;">* wajib diisi</span></h6>
                                            <input type="radio" class="btn-check" name="keberadaan-barang" id="ditemukan" value="BD" <?php if ($bmn['kbrdn_brg'] == 'BD') {
                                                                                                                                            echo 'checked';
                                                                                                                                        } ?> autocomplete="off" />
                                            <label class="btn btn-sm btn-outline-success" for="ditemukan">Ditemukan</label>
                                            <input type="radio" class="btn-check" name="keberadaan-barang" id="berlebih" value="BR" <?php if ($bmn['kbrdn_brg'] == 'BR') {
                                                                                                                                        echo 'checked';
                                                                                                                                    } ?> autocomplete="off" />
                                            <label class="btn btn-sm btn-outline-warning" for="berlebih">Berlebih</label>
                                            <input type="radio" class="btn-check" name="keberadaan-barang" id="tidak-ditemukan" value="BTD" <?php if ($bmn['kbrdn_brg'] == 'BTD') {
                                                                                                                                                echo 'checked';
                                                                                                                                            } ?> autocomplete="off" />
                                            <label class="btn btn-sm btn-outline-danger" for="tidak-ditemukan">Tidak Ditemukan</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="mb-5 d-none" id="kategori_btd">
                                            <h6 class="form-label">kategori barang tidak ditemukan <span class="text-danger text-sm" style="font-weight: 400;">* wajib diisi</span></h6>
                                            <div class="form-group">
                                                <fieldset class="form-group">
                                                    <select class="form-select" name="kategori_btd" id="kategori-btd">
                                                        <option selected disabled>Pilih Kategori</option>
                                                        <option value="1">Hilang</option>
                                                        <option value="2">Salah Kodefikasi</option>
                                                        <option value="3">pekerjaan renovasi/pengembangan BMN dicatat sebagai NUP baru</option>
                                                        <option value="4">pencatatanganda/fiktif</option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                        </div>

                                        <div class="mb-5 d-none" id="kategori_bb">
                                            <h6 class="form-label">kategori barang berlebih <span class="text-danger text-sm" style="font-weight: 400;">* wajib diisi</span></h6>
                                            <div class="form-group">
                                                <fieldset class="form-group">
                                                    <select class="form-select" name="kategori_br" id="kategori-br">
                                                        <option selected disabled>Pilih Kategori</option>
                                                        <option value="1">belum tercatat dalam laporan BMN</option>
                                                        <option value="2">salah kodefikasi</option>
                                                        <option value="3">pencatatan gelondongan</option>
                                                    </select>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="mb-5">
                                            <h6 class="form-label">Nama Pegawai Pengguna Barang <span class="text-danger text-sm" style="font-weight: 400;">* wajib diisi</span></h6>
                                            <div class="form-group">
                                                <fieldset class="form-group">
                                                    <select class="form-select" name="pegawai">
                                                        <option selected disabled>Cari pegawai</option>
                                                        <?php if ($list_pegawai != null) : ?>
                                                            <?php foreach ($list_pegawai as $pegawai) : ?>
                                                                <?php $nama_pegawai = $pegawai['gelar_depan'];
                                                                if ($pegawai['gelar_depan'] != null) {
                                                                    $nama_pegawai .= ' ';
                                                                }
                                                                $nama_pegawai .= $pegawai['nama_pegawai'];
                                                                if ($pegawai['gelar_belakang'] != null) {
                                                                    $nama_pegawai .= ' ';
                                                                }
                                                                $nama_pegawai .= $pegawai['gelar_belakang']; ?>
                                                                <?php if ($bmn['pegawai_id'] != null) : ?>
                                                                    <?php if ($bmn['pegawai_id'] == $pegawai['id_pegawai']) : ?>
                                                                        <option selected value="<?= $bmn['pegawai_id']; ?>"><?= $nama_pegawai; ?></option>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                            <?php foreach ($list_pegawai as $pegawai) : ?>
                                                                <?php $nama_pegawai = $pegawai['gelar_depan'];
                                                                if ($pegawai['gelar_depan'] != null) {
                                                                    $nama_pegawai .= ' ';
                                                                }
                                                                $nama_pegawai .= $pegawai['nama_pegawai'];
                                                                if ($pegawai['gelar_belakang'] != null) {
                                                                    $nama_pegawai .= ' ';
                                                                }
                                                                $nama_pegawai .= $pegawai['gelar_belakang']; ?>
                                                                <option value="<?= $pegawai['id_pegawai']; ?>"><?= $nama_pegawai; ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-5">
                                            <h6>Nama Gedung <span class="text-danger text-sm" style="font-weight: 400;">* wajib diisi</span></h6>
                                            <fieldset class="form-group">
                                                <select class="form-select" name="nama-gedung">
                                                    <option selected disabled>Cari Gedung</option>
                                                    <?php if ($list_gedung != null) : ?>
                                                        <?php foreach ($list_gedung as $gedung) : ?>
                                                            <?php if ($bmn['gedung_id'] != null) : ?>
                                                                <?php if ($bmn['gedung_id'] == $gedung['id']) : ?>
                                                                    <option selected value="<?= $gedung['id']; ?>"><?= $gedung['nama_gedung']; ?></option>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                        <?php foreach ($list_gedung as $gedung) : ?>
                                                            <option value="<?= $gedung['id']; ?>"><?= $gedung['nama_gedung']; ?></option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-5">
                                            <h6>Nama Ruangan <span class="text-danger text-sm" style="font-weight: 400;">* wajib diisi</span></h6>
                                            <fieldset class="form-group">
                                                <select class="form-select" name="nama-ruangan">
                                                    <option selected disabled>Cari Ruangan</option>
                                                    <?php if ($list_ruangan != null) : ?>
                                                        <?php foreach ($list_ruangan as $ruangan) : ?>
                                                            <?php if ($bmn['ruangan_id'] != null) : ?>
                                                                <?php if ($bmn['ruangan_id'] == $ruangan['id']) : ?>
                                                                    <option selected value="<?= $ruangan['id']; ?>"><?= $ruangan['nama_ruang']; ?></option>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                        <?php foreach ($list_ruangan as $ruangan) : ?>
                                                            <option value="<?= $ruangan['id']; ?>"><?= $ruangan['nama_ruang']; ?></option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="mb-5">
                                            <h6>Pelabelan Kodefikasi <span class="text-danger text-sm" style="font-weight: 400;">* wajib diisi</span></h6>
                                            <input type="radio" class="btn-check" name="pelabelan" id="sudah" value="S" <?php if ($bmn['label_kode'] == 'S') {
                                                                                                                            echo 'checked';
                                                                                                                        } ?> autocomplete="off" />
                                            <label class="btn btn-sm btn-outline-success" for="sudah">Sudah</label>

                                            <input type="radio" class="btn-check" name="pelabelan" id="belum" value="B" <?php if ($bmn['label_kode'] == 'B') {
                                                                                                                            echo 'checked';
                                                                                                                        } ?> autocomplete="off" />
                                            <label class="btn btn-sm btn-outline-danger" for="belum">Belum</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-5">
                                            <h6>Status PSP <span class="text-danger text-sm" style="font-weight: 400;">* wajib diisi</span></h6>
                                            <input type="radio" class="btn-check" name="status-psp" id="sudah-psp" value="S" <?php if ($bmn['status_psp'] == 'S') {
                                                                                                                                    echo 'checked';
                                                                                                                                } ?> autocomplete="off" />
                                            <label class="btn btn-sm btn-outline-success" for="sudah-psp">Sudah</label>

                                            <input type="radio" class="btn-check" name="status-psp" id="belum-psp" value="B" <?php if ($bmn['status_psp'] == 'B') {
                                                                                                                                    echo 'checked';
                                                                                                                                } ?> autocomplete=" off" />
                                            <label class="btn btn-sm btn-outline-danger" for="belum-psp">Belum</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="mb-5">
                                            <h6>Nama Sub Satker (opsional)</h6>
                                            <fieldset class="form-group">
                                                <select class="form-select" name="nama-subsatker">
                                                    <option selected disabled>Cari Sub Satker</option>
                                                    <?php if ($list_subsatker != null) : ?>
                                                        <?php foreach ($list_subsatker as $subsatker) : ?>
                                                            <?php if ($bmn['subsatker_id'] != null) : ?>
                                                                <?php if ($bmn['subsatker_id'] == $subsatker['id']) : ?>
                                                                    <option selected value="<?= $subsatker['id']; ?>"><?= $subsatker['nama_subsatker']; ?></option>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                        <?php foreach ($list_subsatker as $subsatker) : ?>
                                                            <option value="<?= $subsatker['id']; ?>"><?= $subsatker['nama_subsatker']; ?></option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4 mb-5">
                                        <h6>Nilai Buku / nilai BMN setelah penyusutan (opsional)</h6>
                                        <div class="input-group mb-2">
                                            <label for="nilai_bmn_minus" class="input-group-text">Rp.</label>
                                            <input type="number" min="0" name="nilai_bmn_minus" id="nilai_bmn_minus" class="form-control border-2">
                                        </div>
                                        <span class="badge bg-light-warning"><u>Nilai buku</u> diisikan ketika barang mengalami penyusutan nilai dari nilai perolehan BMN</span>
                                        <span class="badge bg-light-warning"> Inputkan nilai aset setelah penyusutan, misal: Rp. 1.000 menjadi Rp. 900, maka inputkan nilai <strong><u>Rp. 900</u></strong></span>

                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-5">
                                            <h6>Keterangan</h6>
                                            <div class="form-group">
                                                <textarea class="form-control" name="ket" placeholder="Isi Keterangan" rows="7"><?= $bmn['ket']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary float-end">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    <?php endif; ?>
<?php endif; ?>
<?= $this->endSection(); ?>