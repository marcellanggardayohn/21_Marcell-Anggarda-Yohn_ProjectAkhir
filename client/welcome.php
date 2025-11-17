<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome - McKingsley Contractor</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="welcome.css">
</head>

<body>


<!-- NAVBAR -->
<header>
    <div class="brand">McKingsley Contractor</div>

    <div class="right-nav">
        <span class="username">
    Hi, <?= $_SESSION['fullname']; ?> (<?= $_SESSION['username']; ?>) !
</span>


        <a href="myprojects.php">
            <button class="nav-btn btn-projects">My Projects</button>
        </a>

        <a href="welcome.php">
            <button class="nav-btn btn-home">Home</button>
        </a>

        <a href="logout.php">
            <button class="nav-btn btn-logout">Logout</button>
        </a>
    </div>
</header>


<!-- Jumbotron -->
<div class="jumbotron text-center text-white">
  <h1>Selamat Datang di McKingsley Contractor</h1>
  <p>Perusahaan kontraktor internasional terpercaya dalam pembangunan modern dan berkelanjutan sejak 1826, kini ada di Indonesia.</p>
</div>

<!-- Carousel -->
<h3 class="text-center mt-4">Proyek besar yang telah kami kerjakan:</h3>

<div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4000">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="PLANNING.jpg" class="d-block w-100" alt="Proyek 1">
      <div class="carousel-caption">
        <h5>Architectural PLANNING</h5>
        <p>Perencanaan desain bangunan oleh arsitektur bersertifikat internasional </p><br>
        <p>Harga: 20% total construction cost</p>
      </div>
    </div>

    <div class="carousel-item">
      <img src="RESIDENTIAL.avif" class="d-block w-100" alt="Proyek 2">
      <div class="carousel-caption">
        <h5>Residential Construction</h5>
        <p>Pembangunan perumahan maupun rumah kami bisa tangani</p>
      </div>
    </div>

    <div class="carousel-item">
      <img src="COMMERCIAL.webp" class="d-block w-100" alt="Proyek 3">
      <div class="carousel-caption">
        <h5>Commercial Construction</h5>
        <p>Segala kebutuhan pembagunan gedung bisnis maupun pabrik dan industri, kami tangani </p>
      </div>
    </div>

    <div class="carousel-item">
      <img src="SKYSCRAPER.jpg" class="d-block w-100" alt="Proyek 4">
      <div class="carousel-caption">
        <h5>Skyscraper Construction</h5>
        <p>Kami juga melayani pembangunan gedung pencakar langit</p>
      </div>
    </div>

    <div class="carousel-item">
      <img src="RENOVATION.webp" class="d-block w-100" alt="Proyek 5">
      <div class="carousel-caption">
        <h5>Renovasi</h5>
        <p>Gedung setua apapun akan terlihat baru setelah renovasi</p>
      </div>
    </div>
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>

  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<!-- Cards -->
<section class="container my-5">
  <div class="row gy-4">
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Kualitas Premium</h5>
          <p class="card-text">Setiap proyek dibangun dengan standar internasional dan material terbaik.</p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Profesional dan Berpengalaman</h5>
          <p class="card-text">Tim ahli kami memiliki pengalaman lebih dari 15 tahun di bidang konstruksi.</p>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title">Tepat Waktu</h5>
          <p class="card-text">Kami selalu menyelesaikan proyek sesuai timeline tanpa mengorbankan kualitas.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Description -->
<section class="container my-5 text-center">
  <p class="fs-5">McKingsley Contractor berkomitmen menghadirkan solusi konstruksi paling modern, aman, dan efisien untuk kebutuhan Indonesia.</p>
</section>


<!-- FOOTER -->
<footer class="bg-dark text-white text-center py-3">
  <p>&copy; 2025 McKingsley Contractor. All rights reserved.</p>
  <p>(531)81225545</p><br>
  <p>McKingsley@admin.MKC</p>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</footer>
</body>
</html>
