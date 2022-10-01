<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Dashboard</h3>
            <p class="text-subtitle text-muted">Rekap data inventarisasi barang milik negara di Fakultas Sains dan Teknologi pada Universitas Jambi</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.html">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="page-content">
    <section class="row">
        <div class="col-12 col-lg-12">
            <div class="row">
                <div class="col-8"></div>
                <div class="col-6 col-sm-4 float-end">
                    <fieldset class="form-group">
                        <select class="form-select" id="basicSelect">
                            <option>- Satker -</option>
                            <option>Fakultas Sains dan Teknologi</option>
                            <option>Fakultas Hukum</option>
                            <option>Fakultas Peternakan</option>
                        </select>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-muted">Unit Satker: <span class="font-bold">Fakultas Sains dan Teknologi</span></p>
                                    <p class="text-muted">Total barang: <span class="font-bold">1.122</span></p>
                                </div>
                                <div class="col-6">
                                    <div class="float-end">
                                        <h3 class="text-end">PM NON TIK</h3>
                                        <p class="text-muted text-end">Peralatan Mesin Non TIK</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <a href="sudah.html" class="badge bg-light-success pt-3 w-100">
                                        <h6>Sudah diproses</h6>
                                        <h1 class="my-4">2.231</h1>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="belum.html" class="badge bg-light-danger pt-3 w-100">
                                        <h6>Belum diproses</h6>
                                        <h1 class="my-4">1.084</h1>
                                    </a>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <a href="listdetail.html" class="btn btn-outline-primary w-100">Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-muted">Unit Satker: <span class="font-bold">Fakultas Sains dan Teknologi</span></p>
                                    <p class="text-muted">Total barang: <span class="font-bold">1.122</span></p>
                                </div>
                                <div class="col-6">
                                    <div class="float-end">
                                        <h3 class="text-end">PM TIK</h3>
                                        <p class="text-muted text-end">Peralatan Mesin TIK</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <a href="sudah.html" class="badge bg-light-success pt-3 w-100">
                                        <h6>Sudah diproses</h6>
                                        <h1 class="my-4">128</h1>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="belum.html" class="badge bg-light-danger pt-3 w-100">
                                        <h6>Belum diproses</h6>
                                        <h1 class="my-4">1.200</h1>
                                    </a>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <a href="listdetail.html" class="btn btn-outline-primary w-100">Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-muted">Unit Satker: <span class="font-bold">Fakultas Sains dan Teknologi</span></p>
                                    <p class="text-muted">Total barang: <span class="font-bold">1.122</span></p>
                                </div>
                                <div class="col-6">
                                    <div class="float-end">
                                        <h3 class="text-end">ATB</h3>
                                        <p class="text-muted text-end">Aset Tak Berwujud</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <a href="sudah.html" class="badge bg-light-success pt-3 w-100">
                                        <h6>Sudah diproses</h6>
                                        <h1 class="my-4">980</h1>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="belum.html" class="badge bg-light-danger pt-3 w-100">
                                        <h6>Belum diproses</h6>
                                        <h1 class="my-4">7.248</h1>
                                    </a>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <a href="listdetail.html" class="btn btn-outline-primary w-100">Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-body px-4 py-4-5">
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-muted">Unit Satker: <span class="font-bold">Fakultas Sains dan Teknologi</span></p>
                                    <p class="text-muted">Total barang: <span class="font-bold">1.122</span></p>
                                </div>
                                <div class="col-6">
                                    <div class="float-end">
                                        <h3 class="text-end">ATL</h3>
                                        <p class="text-muted text-end">Aset Tetap Lainnya</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <a href="sudah.html" class="badge bg-light-success pt-3 w-100">
                                        <h6>Sudah diproses</h6>
                                        <h1 class="my-4">4.231</h1>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="belum.html" class="badge bg-light-danger pt-3 w-100">
                                        <h6>Belum diproses</h6>
                                        <h1 class="my-4">120</h1>
                                    </a>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <a href="listdetail.html" class="btn btn-outline-primary w-100">Detail</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                                                  <div class="col-12">
                                                       <div class="card">
                                                            <div class="card-header">
                                                                 <h4>Rekap Data</h4>
                                                            </div>
                                                            <div class="card-body">
                                                                 <div id="chart-profile-visit"></div>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div> -->
        </div>
    </section>
</div>
<?= $this->endSection(); ?>