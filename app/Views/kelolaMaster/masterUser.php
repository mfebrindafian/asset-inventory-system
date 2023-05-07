<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Daftar User</h3>
            <p class="text-subtitle text-muted">Berikut merupakan daftar pengguna aplikasi Sibamira</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">user</li>
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
                <div class="col-7 ">
                    <button data-bs-target="#modal-tambah" data-bs-toggle="modal" class="btn btn-primary float-md-end">Tambah</button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-lg">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Pegawai</th>
                                                <th>Level</th>
                                                <th>Satker</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $list_cek = []; ?>
                                            <?php $no = 1; ?>
                                            <?php if ($list_user != null) : ?>
                                                <?php foreach ($list_user as $user) : ?>
                                                    <?php if (in_array($user['nama_pegawai'], $list_cek) == false) : ?>
                                                        <tr>
                                                            <td><?= $no; ?></td>
                                                            <td><?= $user['gelar_depan'] . ' ' . $user['nama_pegawai'] . ' ' . $user['gelar_belakang'] ?></td>
                                                            <td>
                                                                <?php foreach ($list_akses as $akses) : ?>
                                                                    <?php if ($akses['user_id'] == $user['user_id']) : ?>
                                                                        <span class="badge bg-light-info"><?php if ($akses['level_id'] == '1') {
                                                                                                                echo 'Super Admin';
                                                                                                            } elseif ($akses['level_id'] == '2') {
                                                                                                                echo 'Operator Universitas';
                                                                                                            } else {
                                                                                                                echo 'Operator Unit Kerja';
                                                                                                            } ?></span>
                                                                    <?php endif; ?>
                                                                <?php endforeach; ?>
                                                            </td>
                                                            <td><?= $list_unit_kerja[($no - 1)]; ?></td>
                                                            <td><button data-bs-target="#modal-edit" data-bs-toggle="modal" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil-fill"></i></button></td>
                                                        </tr>
                                                        <?php $no++; ?>
                                                    <?php endif; ?>
                                                    <?php $list_cek[] = $user['nama_pegawai']; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
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


<!-- MODAL TAMBAH-->
<div class="modal fade text-left modal-borderless" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable " role="document">
        <form action="" method="" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah User</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <strong>Pilih Level</strong>
                <div class="d-flex flex-wrap leveling mb-4 mt-2">
                    <div class="pilih-level ">
                        <label for="level3" class="checkbox-level active">
                            <input class="d-none" type="checkbox" name="level_pick3" id="level3">
                            <i class="bi bi-square"></i>
                            Operator Univ
                        </label>
                        <label for="level4" class="checkbox-level active">
                            <input class="d-none" type="checkbox" name="level_pick4" id="level4">
                            <i class="bi bi-square"></i>
                            Operator Unit Kerja
                        </label>
                    </div>
                </div>
                <fieldset class="form-group">
                    <select class="form-select" name="pegawai">
                        <option disabled selected value="null">- Cari Pegawai -</option>
                        <?php if ($list_user != null) : ?>
                            <?php foreach ($list_user as $user) : ?>

                                <option value="<?= $user['user_id']; ?>"><?= $user['gelar_depan'] . ' ' . $user['nama_pegawai'] . ' ' . $user['gelar_belakang'] ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </fieldset>
                <div class="hasil">
                    <div class="divider">
                        <div class="divider-text">detail</div>
                    </div>
                    <div class="row ket">

                        <div class="col-6 text-center">
                            <p><strong>NIP</strong></p>
                            <span class="nip-fill">1992382938472</span>
                        </div>
                        <div class="col-6 text-center">
                            <p><strong>Username</strong></p>
                            <span class="username-fill">budiman</span>
                        </div>
                    </div>
                </div>
                <fieldset class="form-group mt-5">
                    <select class="form-select" name="satker">
                        <option disabled selected value="null">- Pilih Unit Kerja -</option>
                        <option value="1">Fakultas Sains dan Teknologi</option>
                        <option value="2">Fakultas Hukum</option>
                        <option value="3">Fakultas Pertanian</option>
                    </select>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                    <span>Batal</span>
                </button>
                <button type="submit" class="btn btn-primary ml-1">
                    <span>Tambah</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT -->
<div class="modal fade text-left modal-borderless" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable " role="document">
        <form action="" method="" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body">
                <strong>Pilih Level</strong>
                <div class="d-flex flex-wrap leveling mb-4 mt-2">
                    <div class="pilih-level ">
                        <label for="level" class="checkbox-level active">
                            <input class="d-none" type="checkbox" name="level_pick" id="level">
                            <i class="bi bi-square"></i>
                            Operator Univ
                        </label>
                        <label for="level2" class="checkbox-level active">
                            <input class="d-none" type="checkbox" name="level_pick2" id="level2">
                            <i class="bi bi-square"></i>
                            Operator Unit Kerja
                        </label>
                    </div>
                </div>
                <fieldset class="form-group">
                    <select class="form-select" name="pegawai">
                        <option disabled selected value="null">- Cari Pegawai -</option>
                        <option value="1">Budiman</option>
                        <option value="2">Joko</option>
                        <option value="3">Widodo</option>
                    </select>
                </fieldset>
                <div class="hasil">
                    <div class="divider">
                        <div class="divider-text">detail</div>
                    </div>
                    <div class="row ket">

                        <div class="col-6 text-center">
                            <p><strong>NIP</strong></p>
                            <span class="nip-fill">1992382938472</span>
                        </div>
                        <div class="col-6 text-center">
                            <p><strong>Username</strong></p>
                            <span class="username-fill">budiman</span>
                        </div>
                    </div>
                </div>
                <fieldset class="form-group mt-5">
                    <select class="form-select" name="satker">
                        <option disabled selected value="null">- Pilih Unit Kerja -</option>
                        <option value="1">Fakultas Sains dan Teknologi</option>
                        <option value="2">Fakultas Hukum</option>
                        <option value="3">Fakultas Pertanian</option>
                    </select>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                    <span>Batal</span>
                </button>
                <button type="submit" class="btn btn-primary ml-1">
                    <span>Update</span>
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>