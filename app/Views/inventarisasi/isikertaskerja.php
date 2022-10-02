<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
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
                            <h4 class="card-title">Uninterruptible Power Supply (UPS)</h4>
                            <span class="badge bg-light-primary">PM NON TIK</span>
                            <span>Nama Unit Satker: Fakultas Sains dan Teknologi</span>
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
                                <p class="text-muted">3060101048</p>

                                <h6>Tahun Perolehan</h6>
                                <p class="text-muted">2019</p>
                            </div>
                            <div class="col-sm-4">
                                <h6>Nomor Urut Pendaftaran</h6>
                                <p class="text-muted">1</p>

                                <h6>Merek/tipe</h6>
                                <p class="text-muted">UPS 602B</p>
                            </div>
                            <div class="col-sm-4">
                                <h6>Kuantitas</h6>
                                <p class="text-muted">10</p>

                                <h6>Nilai BMN</h6>
                                <p class="text-muted">Rp. 3.355.000</p>
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
                            <h4 class="card-title">Uninterruptible Power Supply (UPS)</h4>
                        </div>
                    </div>
                </div>

                <div class="card-content">
                    <form action="" method="" class="card-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-5">
                                    <h6>Kondisi Barang <span class="text-danger">*</span></h6>
                                    <input type="radio" class="btn-check" name="kondisi-barang" id="baik" autocomplete="off" />
                                    <label class="btn btn-sm btn-outline-success" for="baik">Baik</label>

                                    <input type="radio" class="btn-check" name="kondisi-barang" id="rusak-ringan" autocomplete="off" />
                                    <label class="btn btn-sm btn-outline-warning" for="rusak-ringan">Rusak Ringan</label>

                                    <input type="radio" class="btn-check" name="kondisi-barang" id="rusak-berat" autocomplete="off" />
                                    <label class="btn btn-sm btn-outline-danger" for="rusak-berat">Rusak Berat</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-5">
                                    <h6>Keberadaan Barang <span class="text-danger">*</span></h6>
                                    <input type="radio" class="btn-check" name="keberadaan-barang" id="ditemukan" autocomplete="off" />
                                    <label class="btn btn-sm btn-outline-success" for="ditemukan">Ditemukan</label>

                                    <input type="radio" class="btn-check" name="keberadaan-barang" id="tidak-ditemukan" autocomplete="off" />
                                    <label class="btn btn-sm btn-outline-warning" for="tidak-ditemukan">Tidak Ditemukan</label>

                                    <input type="radio" class="btn-check" name="keberadaan-barang" id="berlebih" autocomplete="off" />
                                    <label class="btn btn-sm btn-outline-danger" for="berlebih">Berlebih</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-5">
                                    <h6>Pelabelan Kodefikasi <span class="text-danger">*</span></h6>
                                    <input type="radio" class="btn-check" name="pelabelan" id="sudah" autocomplete="off" />
                                    <label class="btn btn-sm btn-outline-success" for="sudah">Sudah</label>

                                    <input type="radio" class="btn-check" name="pelabelan" id="belum" autocomplete="off" />
                                    <label class="btn btn-sm btn-outline-danger" for="belum">Belum</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-5">
                                    <h6 class="form-label">Nama Pegawai Pengguna Barang <span class="text-danger">*</span></h6>
                                    <div class="form-group">
                                        <input type="text" name="" class="form-control" id="" placeholder="Cari pegawai ..." />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-5">
                                    <h6>Nama Gedung <span class="text-danger">*</span></h6>
                                    <fieldset class="form-group">
                                        <select class="form-select" name="nama-gedung">
                                            <option>- Satker -</option>
                                            <option>Fakultas Sains dan Teknologi</option>
                                            <option>Fakultas Hukum</option>
                                            <option>Fakultas Peternakan</option>
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mb-5">
                                    <h6>Nama Ruangan <span class="text-danger">*</span></h6>
                                    <fieldset class="form-group">
                                        <select class="form-select" name="nama-ruangan">
                                            <option>- Ruangan -</option>
                                            <option>Lab ICT</option>
                                            <option>Ruang Dekanat</option>
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="mb-5">
                                    <h6>Status PSP <span class="text-danger">*</span></h6>
                                    <input type="radio" class="btn-check" name="status-psp" id="sudah-psp" autocomplete="off" />
                                    <label class="btn btn-sm btn-outline-success" for="sudah-psp">Sudah</label>

                                    <input type="radio" class="btn-check" name="status-psp" id="belum-psp" autocomplete="off" />
                                    <label class="btn btn-sm btn-outline-danger" for="belum-psp">Belum</label>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="mb-5">
                                    <h6>Nama Sub Satker <span class="text-danger">*</span></h6>
                                    <fieldset class="form-group">
                                        <select class="form-select" name="nama-sub-satker">
                                            <option>- Sub Satker -</option>
                                            <option>Sub Satker 1</option>
                                            <option>Sub Satker 2</option>
                                            <option>Sub Satker 3</option>
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-5">
                                    <h6>Keterangan</h6>
                                    <div class="form-group">
                                        <textarea class="form-control" placeholder="Isi Keterangan" rows="7"></textarea>
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
<?= $this->endSection(); ?>