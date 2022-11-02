<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= $title ?></title>

  <link rel="stylesheet" href="/assets/css/main/app.css" />
  <link rel="stylesheet" href="/assets/css/main/app-dark.css" />
  <link rel="shortcut icon" href="/assets/images/logo-unja.png" type="image/x-icon" />
  <link rel="shortcut icon" href="/assets/images/logo-unja.png" type="image/png" />
  <link rel="stylesheet" href="<?= base_url('/assets/css/custom.css') ?>" />
  <?= $this->include('layout/css/' . $halaman) ?>
</head>

<body>
  <div id="app">
    <div id="sidebar" class="active">
      <?= $this->include('layout/sidebar') ?>
    </div>
    <div id="main" class="layout-navbar">

      <?= $this->include('layout/header') ?>

      <div id="main-content" class="pt-0">
        <div class="page-heading">
          <?= $this->renderSection('content'); ?>
          <?= $this->include('layout/footer') ?>
        </div>
      </div>
    </div>
  </div>
  <script src="/assets/js/bootstrap.js"></script>
  <script src="/assets/js/app.js"></script>
  <?= $this->include('layout/js/' . $halaman) ?>
</body>

</html>