<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Dashboard</h3>
            <p class="text-subtitle text-muted">Rekap data inventarisasi barang milik negara pada Universitas Jambi</p>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
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
                        <!-- <select class="form-select" id="basicSelect">
                            <option>- Satker -</option>
                            <?php if ($list_satker != null) : ?>
                                <?php foreach ($list_satker as $satker) : ?>
                                    <option value="<?= $satker['id']; ?>"> <a href="/aa"><?= $satker['nama_satker']; ?></a></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select> -->
                        <div class="input-group">
                            <form action="" method="GET">
                                <select class="form-control filter mr-2" name="satker_choose" id="satker_choose" style="border-radius: 5px;">
                                    <option selected value="">- Satuan Kerja -</option>
                                    <?php if ($list_satker != null) : ?>
                                        <?php foreach ($list_satker as $satker) : ?>
                                            <option value="<?= $satker['id']; ?>"><?= $satker['nama_satker']; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <button id="btn-submit" class="d-none" type="submit">test</button>
                            </form>
                        </div>
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <?php $ke = 1; ?>
                <?php if ($list_akun != null) : ?>
                    <?php foreach ($list_akun as $akun) : ?>

                        <div class="col-12 col-lg-6 col-md-12">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-6">
                                            <p class="text-muted">Unit Satker: <span class="font-bold"></span></p>
                                            <p class="text-muted">Total barang: <span class="font-bold"><?= $data_bmn['all'][$ke]; ?></span></p>
                                        </div>
                                        <div class="col-6">
                                            <div class="float-end">
                                                <h3 class="text-end"><?= $akun['ur_akun']; ?></h3>
                                                <p class="text-muted text-end"><?= $akun['ket_akun']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <a href="<?= base_url('/list-bmn-dashboard') ?>" class="badge bg-light-success pt-3 w-100">
                                                <h6 class="text-wrap">Sudah diproses</h6>
                                                <h1 class="my-4 text-truncate"><?= $data_bmn['sudah'][$ke]; ?></h1>
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <a href="<?= base_url('/list-bmn-dashboard') ?>" class="badge bg-light-danger pt-3 w-100">
                                                <h6 class="text-wrap">Belum diproses</h6>
                                                <h1 class="my-4 text-truncate"><?= $data_bmn['belum'][$ke]; ?></h1>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <a href="<?= base_url('/list-bmn-dashboard') ?>" class="btn btn-outline-primary w-100">Detail</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $ke++ ?>
                    <?php endforeach; ?>
                <?php endif ?>
            </div>
    </section>
</div>
<script src="<?= base_url('/plugins/jquery/jquery.min.js') ?>"></script>
<script>
    let searchParams = new URLSearchParams(window.location.search)
    searchParams.has('satker_choose') // true

    let param = searchParams.get('satker_choose')
    $('#satker_choose').val(param)
    $(document).on('change', '#satker_choose', function() {
        $('#btn-submit').click()

        $(this).val()
    })
</script>
<?= $this->endSection(); ?>