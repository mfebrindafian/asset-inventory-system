<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Detail KKI</h3>
            <p class="text-subtitle text-muted">Berikut merupakan detail dari KKI</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="importkki.html">Import KKI</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail KKI</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-12">
            <div class="row mb-4">
                <div class="col-4">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-import">Update</button>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-hapus">Hapus</button>
                </div>
                <div class="col-3"></div>
                <div class="col-5">
                    <div class="form-group">
                        <input type="search" class="form-control" name="" id="" placeholder="Cari ..." />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <p class="text-subtitle text-muted">Satker: <strong>Fakultas Sains dan Teknologi</strong></p>
                </div>
                <div class="col-6">
                    <p class="text-subtitle text-muted text-end">Kode Batch: r94345j</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist ">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="pmnontik-tab" data-bs-toggle="tab" href="#pmnontik" role="tab" aria-controls="pmnontik" aria-selected="false">PM NON TIK</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="pmtik-tab" data-bs-toggle="tab" href="#pmtik" role="tab" aria-controls="pmtik" aria-selected="true">PM TIK</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="atb-tab" data-bs-toggle="tab" href="#atb" role="tab" aria-controls="atb" aria-selected="false">ATB</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="atl-tab" data-bs-toggle="tab" href="#atl" role="tab" aria-controls="atl" aria-selected="false">ATL</a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="pmnontik" role="tabpanel" aria-labelledby="pmnontik-tab">
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
            </div>
        </div>
    </section>
</div>

<!-- MODAL -->
<div class="modal fade text-left modal-borderless" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import KKI</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-muted">Tambahkan data pada batch ini</p>
                <input type="file" class="basic-filepond" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                    <span>Batal</span>
                </button>
                <button type="submit" class="btn btn-primary ml-1">
                    <span>Update</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL -->
<div class="modal fade text-left modal-borderless" id="modal-hapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hapus batch</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body d-flex justify-content-center">
                <h5>Yakin ingin menghapus batch ini?</h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-danger" data-bs-dismiss="modal">
                    <span>Batal</span>
                </button>
                <button type="submit" class="btn btn-danger ml-1">
                    <span>Hapus</span>
                </button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>