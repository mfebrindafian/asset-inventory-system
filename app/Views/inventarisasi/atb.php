<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>ATB</h3>
            <p class="text-subtitle text-muted">Berikut merupakan daftar Aset Tak Berwujud (ATB)</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">ATB</li>
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
                        <input type="search" class="form-control" name="" id="" placeholder="Cari ..." />
                    </div>
                </div>
                <div class="col-2">
                    <button class="btn btn-primary"><i class="bi bi-search"></i></button>
                </div>
                <div class="col-5 col-md-5">
                    <fieldset class="form-group">
                        <select class="form-select" id="basicSelect">
                            <option>- Status -</option>
                            <option>Belum diproses</option>
                            <option>Sudah diproses</option>
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
                                                <td class="text-bold-500"><a href="<?= base_url('/kertas-kerja') ?>" class="btn btn-sm btn-danger">Check</a></td>
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
                                                <td class="text-bold-500"><a href="<?= base_url('/kertas-kerja') ?>" class="btn btn-sm btn-success">Check</a></td>
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
                                                <td class="text-bold-500"><a href="<?= base_url('/kertas-kerja') ?>" class="btn btn-sm btn-success">Check</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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
        </div>
    </section>
</div>
<?= $this->endSection(); ?>