<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>McKingsley Contractor - Homepage</title>
  <meta name="author" content="Marcell Anggarda Yohn XII-4/21">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="homepage_styling.css">
  <link rel="icon" href="Logo McKingsley.png">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<!-- Navbar -->

<header>
    <div class="brand">McKingsley Contractor</div>

    <div class="right-nav">
        <a href="homepage.php" class="nav-btn">Beranda</a>
        <a href="login.php" class="nav-btn">Login</a>
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
      <img src="ASML.webp" class="d-block w-100" alt="Proyek 1">
      <div class="carousel-caption">
        <h5>ASML HQ and Factory</h5>
        <p>Pusat semikonduktor pemimpin Eropa di Veldhoven, Belanda.</p>
      </div>
    </div>

    <div class="carousel-item">
      <img src="BUCKINGHAM.webp" class="d-block w-100" alt="Proyek 2">
      <div class="carousel-caption">
        <h5>Renovasi Buckingham Palace</h5>
        <p>Renovasi Istana Buckingham, kediaman resmi penguasa Britania Raya </p>
      </div>
    </div>

    <div class="carousel-item">
      <img src="WEMBLEY.webp" class="d-block w-100" alt="Proyek 3">
      <div class="carousel-caption">
        <h5>Wembley Stadium</h5>
        <p>Stadium sepak bola di Wembley, Britania Raya</p>
      </div>
    </div>

    <div class="carousel-item">
      <img src="ROUTE66.webp" class="d-block w-100" alt="Proyek 4">
      <div class="carousel-caption">
        <h5>Route 66</h5>
        <p>Mother road of America</p>
      </div>
    </div>

    <div class="carousel-item">
      <img src="ESB.jpg" class="d-block w-100" alt="Proyek 5">
      <div class="carousel-caption">
        <h5>Menara Bisnis</h5>
        <p>Pembangunan gedung pencakar langit - perkantoran di New York, Amerika Serikat.</p>
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

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3">
  <p>&copy; 2025 McKingsley Contractor. Semua hak cipta dilindungi.</p>
  <p>(531)81225545</p><br>
  <p>McKingsley@admin.MKC</p>
</footer>

</body>
</html>
