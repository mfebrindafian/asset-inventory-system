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
                        <input type="search" class="form-control" name="" id="" placeholder="Cari ..." />
                    </div>
                </div>
                <div class="col-4">
                    <fieldset class="form-group">
                        <select class="form-select" id="basicSelect">
                            <option>- Uraian Akun -</option>
                            <option>PM NON TIK</option>
                            <option>PM TIK</option>
                            <option>ATL</option>
                            <option>ATB</option>
                        </select>
                    </fieldset>
                </div>
                <div class="col-3">
                    <button class="btn btn-primary"><i class="bi bi-search"></i></button>
                </div>
            </div>
            <!-- <div class="row">
                                             <div class="col-12">
                                                  <div class="row">
                                                       <div class="col-12 col-md-6">
                                                            <div class="card">
                                                                 <div class="row px-4 pt-4">
                                                                      <div class="col-6">
                                                                           <h4 class="card-title">Rak-Rak Penyimpan</h4>
                                                                           <span>Nomor Urut Pendaftaran : 1</span>
                                                                      </div>
                                                                      <div class="col-6">
                                                                           <span class="badge bg-light-danger float-end">Belum Dilabeli</span>
                                                                      </div>
                                                                 </div>
                                                                 <div class="row px-4 pt-2 pb-4">
                                                                      <div class="col-md-10 d-flex align-items-end">
                                                                           <span class="badge bg-light-primary">PM NON TIK</span>
                                                                      </div>
                                                                      <div class="col-md-2 mt-3 mt-md-0 d-flex justify-content-end align-items-end">
                                                                           <a href="<?= base_url('/detail-label') ?>" class="btn btn-outline-primary">Cetak</a>
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                       <div class="col-12 col-md-6">
                                                            <div class="card">
                                                                 <div class="row px-4 pt-4">
                                                                      <div class="col-6">
                                                                           <h4 class="card-title">Uninterruptible Power Supply (UPS)</h4>
                                                                           <span>Nomor Urut Pendaftaran : 1</span>
                                                                      </div>
                                                                      <div class="col-6">
                                                                           <span class="badge bg-light-danger float-end">Belum Dilabeli</span>
                                                                      </div>
                                                                 </div>
                                                                 <div class="row px-4 pt-2 pb-4">
                                                                      <div class="col-md-10 d-flex align-items-end">
                                                                           <span class="badge bg-light-primary">PM NON TIK</span>
                                                                      </div>
                                                                      <div class="col-md-2 mt-3 mt-md-0 d-flex justify-content-end align-items-end">
                                                                           <a href="<?= base_url('/detail-label') ?>" class="btn btn-outline-primary">Cetak</a>
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                       <div class="col-12 col-md-6">
                                                            <div class="card">
                                                                 <div class="row px-4 pt-4">
                                                                      <div class="col-6">
                                                                           <h4 class="card-title">Rak-Rak Penyimpan</h4>
                                                                           <span>Nomor Urut Pendaftaran : 3</span>
                                                                      </div>
                                                                      <div class="col-6">
                                                                           <span class="badge bg-light-success float-end"><i class="bi bi-check-lg"></i> Sudah Dilabeli</span>
                                                                      </div>
                                                                 </div>
                                                                 <div class="row px-4 pt-2 pb-4">
                                                                      <div class="col-md-10 d-flex align-items-end">
                                                                           <span class="badge bg-light-primary">PM TIK</span>
                                                                      </div>
                                                                      <div class="col-md-2 mt-3 mt-md-0 d-flex justify-content-end align-items-end">
                                                                           <a href="<?= base_url('/detail-label') ?>" class="btn btn-outline-primary">Cetak</a>
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                       <div class="col-12 col-md-6">
                                                            <div class="card card-text placeholder-glow">
                                                                 <div class="row px-4 pt-4">
                                                                      <div class="col-6">
                                                                           <span class="placeholder rounded col-12"></span><br />
                                                                           <span class="placeholder rounded col-8"></span>
                                                                      </div>
                                                                      <div class="col-6">
                                                                           <span class="float-end placeholder rounded col-4"></span>
                                                                      </div>
                                                                 </div>
                                                                 <div class="row px-4 pt-4 pb-4">
                                                                      <div class="col-md-10 d-flex align-items-end">
                                                                           <span class="placeholder rounded col-2"></span>
                                                                      </div>
                                                                      <div class="col-md-2 mt-3 mt-md-0 d-flex justify-content-end align-items-end">
                                                                           <span class="placeholder rounded col-2 col-md-12 py-3"></span>
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                        </div> -->

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
                                            <tr>
                                                <td class="text-bold-500">1</td>
                                                <td class="text-bold-500">Cermin Besar</td>
                                                <td class="text-bold-500">1</td>
                                                <td class="text-bold-500"><span class="badge bg-light-primary">PM NON TIK</span></td>
                                                <td class="text-bold-500"><span class="badge bg-light-danger">Belum</span></td>
                                                <td class="text-bold-500"><a href="<?= base_url('/detail-label') ?>" class="btn btn-sm btn-primary">Cetak</a></td>
                                            </tr>
                                            <tr>
                                                <td class="text-bold-500">2</td>
                                                <td class="text-bold-500">Uninterruptible Power Supply (UPS)</td>
                                                <td class="text-bold-500">2</td>
                                                <td class="text-bold-500"><span class="badge bg-light-primary">PM TIK</span></td>
                                                <td class="text-bold-500">
                                                    <span class="badge bg-light-success">Sudah <i class="bi bi-check-lg p-0 m-0"></i> </span>
                                                </td>
                                                <td class="text-bold-500"><a href="<?= base_url('/detail-label') ?>" class="btn btn-sm btn-primary">Cetak</a></td>
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