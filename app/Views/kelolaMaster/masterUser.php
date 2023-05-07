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
                                                            <td>
                                                                <button id="btn-edit-user" data-bs-target="#modal-edit" data-bs-toggle="modal" data-id="<?= $user['user_id'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil-fill"></i></button>
                                                                <button id="btn-hapus-user" data-bs-target="#modal-hapus-user" data-bs-toggle="modal" data-id="<?= $user['user_id'] ?>" data-nama-user="<?= $user['gelar_depan'] . ' ' . $user['nama_pegawai'] . ' ' . $user['gelar_belakang'] ?>" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                                            </td>
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
                        <label for="level" class="checkbox-level active">
                            <input class="d-none" type="checkbox" name="level_id" id="level" value="1">
                            <i class="bi bi-square"></i>
                            Super Admin
                        </label>
                        <label for="level2" class="checkbox-level active">
                            <input class="d-none" type="checkbox" name="level_id" id="level2" value="2">
                            <i class="bi bi-square"></i>
                            Operator Univ
                        </label>
                        <label for="level3" class="checkbox-level active">
                            <input class="d-none" type="checkbox" name="level_id" id="level3" value="3">
                            <i class="bi bi-square"></i>
                            Operator Unit Kerja
                        </label>
                    </div>
                </div>
                <fieldset class="form-group">
                    <select class="form-select" name="pegawai" id="cari-pegawai-tambah">
                    </select>
                </fieldset>
                <div class="hasil">
                    <div class="divider">
                        <div class="divider-text">detail</div>
                    </div>
                    <div class="row ket">

                        <div class="col-6 text-center">
                            <p><strong>Nama</strong></p>
                            <span class="nama-fill"></span>
                        </div>
                        <div class="col-6 text-center">
                            <p><strong>NIP</strong></p>
                            <span class="nip-fill"></span>
                        </div>
                    </div>
                </div>
                <fieldset class="form-group d-none mt-5">
                    <select class="form-select " name="satker" id="satker-tambah">
                        <option disabled selected value="null">- Pilih Unit Kerja -</option>
                        <?php if ($daftar_unit_kerja != null) : ?>
                            <?php foreach ($daftar_unit_kerja as $unit_kerja) : ?>
                                <option value="<?= $unit_kerja['id_ref_unit_kerja'] ?>"><?= $unit_kerja['nama_ref_unit_kerja_lengkap'] ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
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
                        <label for="level4" class="checkbox-level active">
                            <input class="d-none" type="checkbox" name="level_id_edit" id="level4" value="1">
                            <i class="bi bi-square"></i>
                            Super Admin
                        </label>
                        <label for="level5" class="checkbox-level active">
                            <input class="d-none" type="checkbox" name="level_id_edit" id="level5" value="2">
                            <i class="bi bi-square"></i>
                            Operator Univ
                        </label>
                        <label for="level6" class="checkbox-level active">
                            <input class="d-none" type="checkbox" name="level_id_edit" id="level6" value="3">
                            <i class="bi bi-square"></i>
                            Operator Unit Kerja
                        </label>
                    </div>
                </div>
                <div class="hasil">
                    <div class="divider">
                        <div class="divider-text">detail</div>
                    </div>
                    <div class="row ket">

                        <div class="col-6 text-center">
                            <p><strong>Nama</strong></p>
                            <span class="nama-fill-edit"></span>
                        </div>
                        <div class="col-6 text-center">
                            <p><strong>NIP</strong></p>
                            <span class="nip-fill-edit"></span>
                        </div>
                    </div>
                </div>
                <fieldset class="form-group mt-5 d-none">
                    <select class="form-select" name="satker" id="satker-edit">
                        <option disabled selected value="null">- Pilih Unit Kerja -</option>
                        <?php if ($daftar_unit_kerja != null) : ?>
                            <?php foreach ($daftar_unit_kerja as $unit_kerja) : ?>
                                <option value="<?= $unit_kerja['id_ref_unit_kerja'] ?>"><?= $unit_kerja['nama_ref_unit_kerja_lengkap'] ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
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

<!-- MODAL HAPUS-->
<div class="modal fade text-left modal-borderless" id="modal-hapus-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable " role="document">
        <form action="" method="" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Hapus User?</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="modal-body text-center">
                <input type="hidden" name="id_user_hapus" id="id-user-hapus">
                <h5 id="nama-user-hapus"></h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-danger" data-bs-dismiss="modal">
                    <span>Batal</span>
                </button>
                <button type="submit" class="btn btn-danger ml-1">
                    <span>Ya</span>
                </button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection(); ?>