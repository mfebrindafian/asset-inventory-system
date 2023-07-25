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
                            <form action="<?= base_url('/cetak-rekapitulasi'); ?>" method="POST" class="col-12">
                                <h5 class="mb-3">Cetak rekapitulasi laporan hasil inventarisasi BMN</h5>
                                <?php if (session('level_id') == 2) :  ?>
                                    <fieldset class="form-group">
                                        <select name="satker" class="form-select">
                                            <option>- Satker -</option>
                                            <option value="all">Seluruh Satker</option>
                                            <?php if ($list_satker != null) : ?>
                                                <?php foreach ($list_satker as $satker) : ?>
                                                    <option value="<?= $satker['id_ref_unit_kerja']; ?>"> <a href="/aa"><?= $satker['nama_ref_unit_kerja_lengkap']; ?></a></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </fieldset>
                                <?php endif; ?>
                                <?php if (session('level_id') == 3) : ?>
                                    <span class="badge bg-light-secondary w-100 mb-3">
                                        <h6 class="m-0 py-2 text-truncate">Fakultas Sains dan Teknologi</h6>
                                    </span>
                                <?php endif; ?>
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
                            <p class="text-muted m-0">Silahkan pilih Satker dan jenis rekapitulasi untuk melihat preview</p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class=" <?= (session('level_id') == 3) ? 'position-absolute d-none' : 'col-sm-5' ?>">
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
                        </div>
                        <div class="col-sm-5 col-12">
                            <fieldset class="form-group">
                                <select class="form-select" id="jenis-rekapitulasi">
                                    <option value="" selected disabled>- Jenis Rekapitulasi -</option>
                                    <?php foreach ($list_jenis_rekapitulasi as $list) : ?>
                                        <option value="<?= $list['id']; ?>"><?= $list['jenis_rekapitulasi']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </fieldset>
                        </div>
                    </div>
                </div>

                <div class="card-content">
                    <div class="card-body pt-0 text-center text-sm-start">
                        <h4 class="card-title mt-4 text-danger" id="jenis"></h4>
                        <hr class="mb-0 mt-4" />
                        <!-- loader -->
                        <div id="loaders" class="p-2 d-none placeholder-glow">
                            <div class="table-responsive">
                                <table class="table table-lg">
                                    <thead>
                                        <tr>
                                            <th>
                                                <div class="col-8 py-3 placeholder rounded"></div>
                                            </th>
                                            <th class="text-center">
                                                <div class="col-9 py-3 placeholder rounded"></div>
                                            </th>
                                            <th class="text-center">
                                                <div class="col-10 py-3 placeholder rounded"></div>
                                            </th>
                                            <th class="text-center">
                                                <div class="col-12 py-3 placeholder rounded"></div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="col-12 py-3 placeholder rounded"></div>
                                            </td>
                                            <td class="text-center">
                                                <div class="col-6 py-3 placeholder rounded"></div>
                                            </td>
                                            <td class="text-center">
                                                <div class="col-8 py-3 placeholder rounded"></div>
                                            </td>
                                            <td class="text-center">
                                                <div class="col-7 py-3 placeholder rounded"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="col-12 py-3 placeholder rounded"></div>
                                            </td>
                                            <td class="text-center">
                                                <div class="col-9 py-3 placeholder rounded"></div>
                                            </td>
                                            <td class="text-center">
                                                <div class="col-5 py-3 placeholder rounded"></div>
                                            </td>
                                            <td class="text-center">
                                                <div class="col-8 py-3 placeholder rounded"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="col-4 py-3 placeholder rounded"></div>
                                            </td>
                                            <td class="text-center">
                                                <div class="col-5 py-3 placeholder rounded"></div>
                                            </td>
                                            <td class="text-center">
                                                <div class="col-6 py-3 placeholder rounded"></div>
                                            </td>
                                            <td class="text-center">
                                                <div class="col-4 py-3 placeholder rounded"></div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="d-none" id="simple">
                            <div class="table-responsive">
                                <table class="table table-lg">
                                    <thead>
                                        <tr>
                                            <th>Akun</th>
                                            <th class="text-center">Jumlah</th>
                                            <th class="text-center">Nilai</th>
                                            <th class="text-center">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="simple-table">

                                    </tbody>
                                </table>
                            </div>
                        </div>


                        <div class="d-none" id="complex">
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
                                    <tbody id="complex-table">

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