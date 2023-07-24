<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Cetak Label</h3>
            <p class="text-subtitle text-muted">Cari barang yang akan diberi label</p>
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
        <div class="col-12 col-lg-12">
            <div class="row mb-4">
                <div class="col-5">
                    <div class="form-group">
                        <input type="text" class="form-control" name="" id="searchbar" placeholder="Cari ..." />
                    </div>
                </div>
                <div class="col-4">
                    <fieldset class="form-group">
                        <select class="form-select" id="uraianakun">
                            <option>- Uraian Akun -</option>
                            <option value="PM_NON_TIK">PM NON TIK</option>
                            <option value="PM_TIK">PM TIK</option>
                            <option value="ATL">ATL</option>
                            <option value="ATB">ATB</option>
                        </select>
                    </fieldset>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <!-- Table with outer spacing -->
                                <div class="table-responsive">
                                    <table class="table table-lg">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Barang</th>
                                                <th>NUP</th>
                                                <th>Jenis Akun</th>
                                                <th>Status Labelisasi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $ke = 1 ?>
                                            <?php if ($list_bmn != null) : ?>
                                                <?php foreach ($list_bmn as $bmn) : ?>
                                                    <tr>
                                                        <td class="text-bold-500"><?= $ke++; ?></td>
                                                        <td class="text-bold-500"><?= $bmn['nama_barang']; ?></td>
                                                        <td class="text-bold-500"><?= $bmn['nup']; ?></td>
                                                        <td class="text-bold-500"><span class="badge bg-light-primary"><?= $bmn['ur_akun']; ?></span></td>
                                                        <td class="text-bold-500"><span class="badge <?php if ($bmn['label_kode'] == null || $bmn['label_kode'] == 'B') {
                                                                                                            echo 'bg-light-danger';
                                                                                                        } else {
                                                                                                            echo 'bg-light-success';
                                                                                                        } ?>"><?php if ($bmn['label_kode'] == null || $bmn['label_kode'] == 'B') {
                                                                                                                    echo 'Belum';
                                                                                                                } else {
                                                                                                                    echo 'Sudah';
                                                                                                                } ?></span></td>
                                                        <td class="text-bold-500"><a href="<?= base_url('/detail-label/' . $bmn['id']) ?>" class="btn btn-sm btn-primary">Cetak</a></td>
                                                    </tr>
                                                <?php endforeach;  ?>
                                            <?php endif;  ?>

                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?= $this->endSection(); ?>