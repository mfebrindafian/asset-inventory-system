<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard</title>

  <link rel="stylesheet" href="css/main/app.css" />
  <link rel="stylesheet" href="css/main/app-dark.css" />
  <link rel="shortcut icon" href="images/logo-unja.png" type="image/x-icon" />
  <link rel="shortcut icon" href="images/logo-unja.png" type="image/png" />

  <link rel="stylesheet" href="css/shared/iconly.css" />
</head>

<body>
  <div id="app">
    <div id="sidebar" class="active">

      <?= $this->renderSection('sidebar'); ?>

    </div>
    <div id="main" class="layout-navbar">

      <?= $this->renderSection('header'); ?>

      <div id="main-content" class="pt-0">
        <div class="page-heading">

          <?= $this->renderSection('content'); ?>

          <?= $this->renderSection('footer'); ?>

        </div>
      </div>
    </div>
  </div>
  <script src="js/bootstrap.js"></script>
  <script src="js/app.js"></script>

  <!-- Need: Apexcharts -->
  <script src="extensions/apexcharts/apexcharts.min.js"></script>
  <script src="js/pages/dashboard.js"></script>
</body>

</html>