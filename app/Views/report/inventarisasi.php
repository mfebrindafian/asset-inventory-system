<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Report Inventarisasi</h3>
            <p class="text-subtitle text-muted">Daftar barang hasil inventarisasi BMN</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../dashboard.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">PM TIK</li>
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
                            <form action="/cetakInventarisasi" method="POST" class="col-12">
                                <h5 class="mb-3">Cetak daftar barang hasil inventarisasi BMN</h5>
                                <div class="row">
                                    <div class="col-6">
                                        <fieldset class="form-group">
                                            <select class="form-select" name="satker" id="satker">
                                                <?php if ($list_satker != null) : ?>
                                                    <?php if (session('level_id') == 3) : ?>
                                                        <?php foreach ($list_satker as $satker) : ?>
                                                            <?php if ($satker['id_ref_unit_kerja'] == session('satker_id')) : ?>
                                                                <option selected value="<?= $satker['id_ref_unit_kerja']; ?>"> <a href="/aa"><?= $satker['nama_ref_unit_kerja_lengkap']; ?></a></option>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <option>- Satker -</option>
                                                        <option value="all"> Seluruh Satker</option>
                                                        <?php foreach ($list_satker as $satker) : ?>
                                                            <option value="<?= $satker['id_ref_unit_kerja']; ?>"> <a href="/aa"><?= $satker['nama_ref_unit_kerja_lengkap']; ?></a></option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </select>
                                        </fieldset>
                                        <!-- <span class="badge bg-light-secondary w-100 mb-3">
                                            <h6 class="m-0 py-1 text-truncate">Fakultas Sains dan Teknologi</h6>
                                        </span> -->
                                    </div>
                                    <div class="col-6">
                                        <fieldset class="form-group">
                                            <select class="form-select" id="jenis-rekapitulasi" name="jenis-inventarisasi" required>
                                                <option value="" selected disabled>- Jenis Inventarisasi -</option>
                                                <?php foreach ($list_jenis_rekapitulasi as $list) : ?>
                                                    <option value="<?= $list['id']; ?>"><?= $list['jenis_rekapitulasi']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </fieldset>
                                    </div>
                                </div>

                                <button class="btn btn-primary w-100">Download</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="card-title">Preview Data</h4>
                            <p class="text-muted m-0">Silahkan pilih Satker dan jenis daftar untuk melihat preview</p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <!-- <div class="col-5">
                                                            <fieldset class="form-group">
                                                                 <select class="form-select">
                                                                      <option>- Satker -</option>
                                                                      <option>Seluruh Satker</option>
                                                                      <option>Fakultas Sains dan Teknologi</option>
                                                                      <option>Fakultas Hukum</option>
                                                                      <option>Fakultas Peternakan</option>
                                                                 </select>
                                                            </fieldset>
                                                       </div> -->
                        <div class="col-5">
                            <fieldset class="form-group">
                                <select class="form-select">
                                    <option>- Jenis Daftar -</option>
                                    <option>Seluruh</option>
                                    <option>Barang ditemukan</option>
                                    <option>Barang tidak diketemukan</option>
                                    <option>Barang baik</option>
                                    <option>Barang rusak ringan</option>
                                    <option>Barang rusak berat</option>
                                    <option>Barang berlebih</option>
                                </select>
                            </fieldset>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-primary"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                    <hr class="mb-0 mt-4" />
                </div>

                <div class="card-content">
                    <div class="card-body pt-0 text-center text-sm-start">
                        <!-- Table with outer spacing -->
                        <div class="table-responsive">
                            <table class="table table-lg">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Tahun Perolehan</th>
                                        <th>NUP</th>
                                        <th>Merek</th>
                                        <th>Kuantitas</th>
                                        <th>Nilai BMN</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-bold-500">1</td>
                                        <td>3030211008</td>
                                        <td class="text-bold-500">Cermin Besar</td>
                                        <td class="text-bold-500">2015</td>
                                        <td class="text-bold-500">2</td>
                                        <td class="text-bold-500">Panasonic</td>
                                        <td class="text-bold-500">1</td>
                                        <td class="text-bold-500">8.635.000</td>
                                        <td class="text-bold-500"><a href="../isidata.html" class="btn btn-sm btn-primary">Detail</a></td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold-500">2</td>
                                        <td>3030211002</td>
                                        <td class="text-bold-500">Rak-Rak Penyimpan</td>
                                        <td class="text-bold-500">2015</td>
                                        <td class="text-bold-500">4</td>
                                        <td class="text-bold-500">Sumber Jaya</td>
                                        <td class="text-bold-500">1</td>
                                        <td class="text-bold-500">2.635.000</td>
                                        <td class="text-bold-500"><a href="../isidata.html" class="btn btn-sm btn-primary">Detail</a></td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold-500">3</td>
                                        <td>3030211001</td>
                                        <td class="text-bold-500">Stopwatch</td>
                                        <td class="text-bold-500">2015</td>
                                        <td class="text-bold-500">5</td>
                                        <td class="text-bold-500">Sumber Jaya</td>
                                        <td class="text-bold-500">10</td>
                                        <td class="text-bold-500">1.635.000</td>
                                        <td class="text-bold-500"><a href="../isidata.html" class="btn btn-sm btn-primary">Detail</a></td>
                                    </tr>
                                </tbody>
                            </table>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination pagination-primary justify-content-end">
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                            <span aria-hidden="true"><i class="bi bi-chevron-left"></i></span>
                                        </a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">
                                            <span aria-hidden="true"><i class="bi bi-chevron-right"></i></span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>