<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Rekapitulasi</h3>
            <p class="text-subtitle text-muted">Rekapitulasi laporan hasil inventarisasi BMN</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">PM NON TIK</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <h5 class="mb-3">Cetak rekapitulasi laporan hasil inventarisasi BMN</h5>
                                <?php if (session('level_id') == 2) :  ?>
                                    <fieldset class="form-group">
                                        <select class="form-select" id="basicSelect">
                                            <option>- Satker -</option>
                                            <option>Seluruh Satker</option>
                                            <?php if ($list_satker != null) : ?>
                                                <?php foreach ($list_satker as $satker) : ?>
                                                    <option value="<?= $satker['id']; ?>"> <a href="/aa"><?= $satker['nama_satker']; ?></a></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </fieldset>
                                <?php endif; ?>
                                <?php if (session('level_id') == 3) : ?>
                                    <span class="badge bg-light-secondary w-100 mb-3">
                                        <h6 class="m-0 py-2">Fakultas Sains dan Teknologi</h6>
                                    </span>
                                <?php endif; ?>
                                <button class="btn btn-primary w-100">Download</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title">Preview Data</h4>
                            <p class="text-muted m-0">Silahkan pilih Satker dan jenis rekapitulasi untuk melihat preview</p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-5">
                            <fieldset class="form-group">
                                <select class="form-select">
                                    <option>- Satker -</option>
                                    <option value="all"> Seluruh Satker</option>
                                    <?php if ($list_satker != null) : ?>
                                        <?php foreach ($list_satker as $satker) : ?>
                                            <option value="<?= $satker['id']; ?>"> <a href="/aa"><?= $satker['nama_satker']; ?></a></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-5">
                            <fieldset class="form-group">
                                <select class="form-select" id="jenis-rekapitulasi">
                                    <option selected disabled>- Jenis Rekapitulasi -</option>
                                    <?php foreach ($list_jenis_rekapitulasi as $list) : ?>
                                        <option value="<?= $list['id']; ?>"><?= $list['jenis_rekapitulasi']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </fieldset>
                        </div>
                        <!-- <div class="col-2">
                            <button class="btn btn-primary"><i class="bi bi-search"></i></button>
                        </div> -->
                    </div>
                </div>

                <div class="card-content">
                    <div class="card-body pt-0 text-center text-sm-start">

                        <div class="tab">
                            <h4 class="card-title mt-4 text-danger">Sebelum dan Sesudah Inventarisasi</h4>
                            <hr class="mb-0 mt-4" />
                            <!-- Sebelum dan sesudah -->
                            <div class="table-responsive">
                                <table class="table table-lg">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Akun</th>
                                            <th colspan="2" class="text-center">Administrasi</th>
                                            <th colspan="2" class="text-center">Inventarisasi</th>
                                            <th colspan="2" class="text-center">Selisih</th>
                                            <th rowspan="2" class="text-center">Keterangan</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Nilai</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Nilai</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-bold-500">Peralatan Mesin NON TIK</td>
                                            <td class="text-center">24</td>
                                            <td class="text-center">Rp. 46.000</td>
                                            <td class="text-center">41</td>
                                            <td class="text-center">Rp. 348.000</td>
                                            <td class="text-center">214</td>
                                            <td class="text-center">Rp. 389.000</td>
                                            <td class="text-bold-500"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-500">Peralatan Mesin TIK</td>
                                            <td class="text-center">58</td>
                                            <td class="text-center">Rp. 45.000</td>
                                            <td class="text-center">58</td>
                                            <td class="text-center">Rp. 389.000</td>
                                            <td class="text-center">9</td>
                                            <td class="text-center">Rp. 120.000</td>
                                            <td class="text-bold-500"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-500">Aset Tetap Lainnya</td>
                                            <td class="text-center">341</td>
                                            <td class="text-center">Rp. 4.000</td>
                                            <td class="text-center">69</td>
                                            <td class="text-center">Rp. 450.000</td>
                                            <td class="text-center">10</td>
                                            <td class="text-center">Rp. 850.000</td>
                                            <td class="text-bold-500"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-500">Aset Tak Berwujud</td>
                                            <td class="text-center">142</td>
                                            <td class="text-center">Rp. 47.000</td>
                                            <td class="text-center">298</td>
                                            <td class="text-center">Rp. 9.000</td>
                                            <td class="text-center">75</td>
                                            <td class="text-center">Rp. 9.000</td>
                                            <td class="text-bold-500"></td>
                                        </tr>
                                        <tr>
                                            <th class="text-bold-500">Total</th>
                                            <th class="text-center">565</th>
                                            <th class="text-center">Rp. 142.000</th>
                                            <th class="text-center">466</th>
                                            <th class="text-center">Rp. 791.000</th>
                                            <th class="text-center">308</th>
                                            <th class="text-center">Rp. 495.000</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="d-none tab">
                            <h4 class="card-title mt-4 text-danger">Barang Ditemukan</h4>
                            <hr class="mb-0 mt-4" />
                            <!-- Barang Ditemukan -->
                            <div class="table-responsive">
                                <table class="table table-lg">
                                    <thead>
                                        <tr>
                                            <th>Akun</th>
                                            <th>Jumlah</th>
                                            <th>Nilai</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-bold-500">Peralatan Mesin NON TIK</td>
                                            <td>24</td>
                                            <td>Rp. 46.000</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-500">Peralatan Mesin TIK</td>
                                            <td>58</td>
                                            <td>Rp. 45.000</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-500">Aset Tetap Lainnya</td>
                                            <td>341</td>
                                            <td>Rp. 4.000</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-500">Aset Tak Berwujud</td>
                                            <td>142</td>
                                            <td>Rp. 47.000</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th class="text-bold-500">Total</th>
                                            <th>565</th>
                                            <th>Rp. 142.000</th>
                                            <th></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="d-none tab">

                            <h4 class="card-title mt-4 text-danger">Barang Tidak Ditemukan</h4>
                            <hr class="mb-0 mt-4" />
                            <!-- Barang Tidak Ditemukan -->
                            <div class="table-responsive">
                                <table class="table table-lg">
                                    <thead>
                                        <tr>
                                            <th>Akun</th>
                                            <th>Jumlah</th>
                                            <th>Nilai</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-bold-500">Peralatan Mesin NON TIK</td>
                                            <td>24</td>
                                            <td>Rp. 46.000</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-500">Peralatan Mesin TIK</td>
                                            <td>58</td>
                                            <td>Rp. 45.000</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-500">Aset Tetap Lainnya</td>
                                            <td>341</td>
                                            <td>Rp. 4.000</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-500">Aset Tak Berwujud</td>
                                            <td>142</td>
                                            <td>Rp. 47.000</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th class="text-bold-500">Total</th>
                                            <th>565</th>
                                            <th>Rp. 142.000</th>
                                            <th></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="d-none tab">
                            <h4 class="card-title mt-4 text-danger">Barang Baik</h4>
                            <hr class="mb-0 mt-4" />
                            <!-- Barang Baik -->
                            <div class="table-responsive">
                                <table class="table table-lg">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Akun</th>
                                            <th colspan="2" class="text-center">Administrasi</th>
                                            <th colspan="2" class="text-center">Inventarisasi</th>
                                            <th colspan="2" class="text-center">Selisih</th>
                                            <th rowspan="2" class="text-center">Keterangan</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Nilai</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Nilai</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-bold-500">Peralatan Mesin NON TIK</td>
                                            <td class="text-center">24</td>
                                            <td class="text-center">Rp. 46.000</td>
                                            <td class="text-center">41</td>
                                            <td class="text-center">Rp. 348.000</td>
                                            <td class="text-center">214</td>
                                            <td class="text-center">Rp. 389.000</td>
                                            <td class="text-bold-500"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-500">Peralatan Mesin TIK</td>
                                            <td class="text-center">58</td>
                                            <td class="text-center">Rp. 45.000</td>
                                            <td class="text-center">58</td>
                                            <td class="text-center">Rp. 389.000</td>
                                            <td class="text-center">9</td>
                                            <td class="text-center">Rp. 120.000</td>
                                            <td class="text-bold-500"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-500">Aset Tetap Lainnya</td>
                                            <td class="text-center">341</td>
                                            <td class="text-center">Rp. 4.000</td>
                                            <td class="text-center">69</td>
                                            <td class="text-center">Rp. 450.000</td>
                                            <td class="text-center">10</td>
                                            <td class="text-center">Rp. 850.000</td>
                                            <td class="text-bold-500"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-500">Aset Tak Berwujud</td>
                                            <td class="text-center">142</td>
                                            <td class="text-center">Rp. 47.000</td>
                                            <td class="text-center">298</td>
                                            <td class="text-center">Rp. 9.000</td>
                                            <td class="text-center">75</td>
                                            <td class="text-center">Rp. 9.000</td>
                                            <td class="text-bold-500"></td>
                                        </tr>
                                        <tr>
                                            <th class="text-bold-500">Total</th>
                                            <th class="text-center">565</th>
                                            <th class="text-center">Rp. 142.000</th>
                                            <th class="text-center">466</th>
                                            <th class="text-center">Rp. 791.000</th>
                                            <th class="text-center">308</th>
                                            <th class="text-center">Rp. 495.000</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="d-none tab">
                            <h4 class="card-title mt-4 text-danger">Barang Rusak Ringan</h4>
                            <hr class="mb-0 mt-4" />
                            <!-- Barang Rusak Ringan -->
                            <div class="table-responsive">
                                <table class="table table-lg">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Akun</th>
                                            <th colspan="2" class="text-center">Administrasi</th>
                                            <th colspan="2" class="text-center">Inventarisasi</th>
                                            <th colspan="2" class="text-center">Selisih</th>
                                            <th rowspan="2" class="text-center">Keterangan</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Nilai</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Nilai</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-bold-500">Peralatan Mesin NON TIK</td>
                                            <td class="text-center">24</td>
                                            <td class="text-center">Rp. 46.000</td>
                                            <td class="text-center">41</td>
                                            <td class="text-center">Rp. 348.000</td>
                                            <td class="text-center">214</td>
                                            <td class="text-center">Rp. 389.000</td>
                                            <td class="text-bold-500"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-500">Peralatan Mesin TIK</td>
                                            <td class="text-center">58</td>
                                            <td class="text-center">Rp. 45.000</td>
                                            <td class="text-center">58</td>
                                            <td class="text-center">Rp. 389.000</td>
                                            <td class="text-center">9</td>
                                            <td class="text-center">Rp. 120.000</td>
                                            <td class="text-bold-500"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-500">Aset Tetap Lainnya</td>
                                            <td class="text-center">341</td>
                                            <td class="text-center">Rp. 4.000</td>
                                            <td class="text-center">69</td>
                                            <td class="text-center">Rp. 450.000</td>
                                            <td class="text-center">10</td>
                                            <td class="text-center">Rp. 850.000</td>
                                            <td class="text-bold-500"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-500">Aset Tak Berwujud</td>
                                            <td class="text-center">142</td>
                                            <td class="text-center">Rp. 47.000</td>
                                            <td class="text-center">298</td>
                                            <td class="text-center">Rp. 9.000</td>
                                            <td class="text-center">75</td>
                                            <td class="text-center">Rp. 9.000</td>
                                            <td class="text-bold-500"></td>
                                        </tr>
                                        <tr>
                                            <th class="text-bold-500">Total</th>
                                            <th class="text-center">565</th>
                                            <th class="text-center">Rp. 142.000</th>
                                            <th class="text-center">466</th>
                                            <th class="text-center">Rp. 791.000</th>
                                            <th class="text-center">308</th>
                                            <th class="text-center">Rp. 495.000</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="d-none tab">
                            <h4 class="card-title mt-4 text-danger">Barang Rusak Berat</h4>
                            <hr class="mb-0 mt-4" />
                            <!-- Barang Rusak Berat -->
                            <div class="table-responsive">
                                <table class="table table-lg">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Akun</th>
                                            <th colspan="2" class="text-center">Administrasi</th>
                                            <th colspan="2" class="text-center">Inventarisasi</th>
                                            <th colspan="2" class="text-center">Selisih</th>
                                            <th rowspan="2" class="text-center">Keterangan</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Nilai</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Nilai</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Nilai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-bold-500">Peralatan Mesin NON TIK</td>
                                            <td class="text-center">24</td>
                                            <td class="text-center">Rp. 46.000</td>
                                            <td class="text-center">41</td>
                                            <td class="text-center">Rp. 348.000</td>
                                            <td class="text-center">214</td>
                                            <td class="text-center">Rp. 389.000</td>
                                            <td class="text-bold-500"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-500">Peralatan Mesin TIK</td>
                                            <td class="text-center">58</td>
                                            <td class="text-center">Rp. 45.000</td>
                                            <td class="text-center">58</td>
                                            <td class="text-center">Rp. 389.000</td>
                                            <td class="text-center">9</td>
                                            <td class="text-center">Rp. 120.000</td>
                                            <td class="text-bold-500"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-500">Aset Tetap Lainnya</td>
                                            <td class="text-center">341</td>
                                            <td class="text-center">Rp. 4.000</td>
                                            <td class="text-center">69</td>
                                            <td class="text-center">Rp. 450.000</td>
                                            <td class="text-center">10</td>
                                            <td class="text-center">Rp. 850.000</td>
                                            <td class="text-bold-500"></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-500">Aset Tak Berwujud</td>
                                            <td class="text-center">142</td>
                                            <td class="text-center">Rp. 47.000</td>
                                            <td class="text-center">298</td>
                                            <td class="text-center">Rp. 9.000</td>
                                            <td class="text-center">75</td>
                                            <td class="text-center">Rp. 9.000</td>
                                            <td class="text-bold-500"></td>
                                        </tr>
                                        <tr>
                                            <th class="text-bold-500">Total</th>
                                            <th class="text-center">565</th>
                                            <th class="text-center">Rp. 142.000</th>
                                            <th class="text-center">466</th>
                                            <th class="text-center">Rp. 791.000</th>
                                            <th class="text-center">308</th>
                                            <th class="text-center">Rp. 495.000</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="d-none tab">
                            <h4 class="card-title mt-4 text-danger">Barang Berlebih</h4>
                            <hr class="mb-0 mt-4" />
                            <!-- Barang Berlebih -->
                            <div class="table-responsive">
                                <table class="table table-lg">
                                    <thead>
                                        <tr>
                                            <th>Akun</th>
                                            <th>Jumlah</th>
                                            <th>Nilai</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-bold-500">Peralatan Mesin NON TIK</td>
                                            <td>24</td>
                                            <td>Rp. 46.000</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-500">Peralatan Mesin TIK</td>
                                            <td>58</td>
                                            <td>Rp. 45.000</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-500">Aset Tetap Lainnya</td>
                                            <td>341</td>
                                            <td>Rp. 4.000</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-500">Aset Tak Berwujud</td>
                                            <td>142</td>
                                            <td>Rp. 47.000</td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <th class="text-bold-500">Total</th>
                                            <th>565</th>
                                            <th>Rp. 142.000</th>
                                            <th></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>