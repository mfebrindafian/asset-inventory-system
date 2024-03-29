<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - SIBAMIRA</title>
    <link rel="stylesheet" href="/assets/css/main/app.css" />
    <link rel="stylesheet" href="/assets/css/pages/auth.css" />
    <link rel="shortcut icon" href="/assets/images/logo-unja.png" type="image/x-icon" />
    <link rel="shortcut icon" href="/assets/images/logo-unja.png" type="image/png" />
    <link href="<?= base_url('/assets/css/add/select2-bootstrap.min.css') ?>" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url('/assets/css/sweetalert-bs4.min.css') ?>">
</head>

<body>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-6 col-12">
                <div id="auth-left">
                    <div class="auth-logo mb-2">
                        <a href="/"><img src="/assets/images/logo-unja.png" alt="Logo" /></a>
                    </div>
                    <h1 class="auth-title">Log in.</h1>
                    <p class="auth-subtitle mb-5">Sistem Inventarisasi Barang Milik Negara Universitas Jambi</p>

                    <form action="<?= base_url('/login'); ?>" method="POST">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" name="username" placeholder="Username" required />
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" name="password" placeholder="Password" required />
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block"><img src="/assets/images/849.png" alt="" style="height: 100vh" /></div>
        </div>
    </div>
</body>
<!-- Bootstrap 4 -->
<script src="<?= base_url('/assets/js/pages/jquery.min.js') ?>"></script>
<script src="<?= base_url('/assets/js/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('/assets/js/sweetalert2/sweetalert2.min.js') ?>"></script>
<script>
    $(document).on('click', "#togglePassword", function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        input = $(this).parent().find("input");
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

    $(document).ready(function() {
        <?php if (session()->getFlashdata('pesan')) { ?>
            Swal.fire({
                title: "<?= session()->getFlashdata('pesan') ?>",
                text: "<?= session()->getFlashdata('pesan_text') ?>",
                icon: "<?= session()->getFlashdata('icon') ?>",
                showConfirmButton: true,
            });
        <?php } ?>
        $('.button').click(function() {
            $(this).children().first().addClass('d-none')
            $('.arc').removeClass('d-none')
        })
    });
</script>

</html>