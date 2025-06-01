<?php
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Creative Agency</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="admin/js/alert.js"></script>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
    }
    .hero {
      background: url('https://images.unsplash.com/photo-1519389950473-47ba0277781c') center/cover no-repeat;
      height: 100vh;
      position: relative;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
    }
    .hero::before {
      content: "";
      background: rgba(0, 0, 0, 0.6);
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0; left: 0;
      z-index: 1;
    }
    .hero-content {
      position: relative;
      z-index: 2;
    }
    .hero h1 {
      font-size: 3rem;
      font-weight: bold;
    }
    .section-title {
      margin: 60px 0 20px;
      text-align: center;
    }
    .feature-icon {
      font-size: 3rem;
      margin-bottom: 10px;
      color: #00bcd4;
    }
    #snow-canvas {
      position: fixed;
      top: 0; left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: 10;
    }
        .bidang-icon {
      width: 80px;
      height: 80px;
      object-fit: contain;
      margin-bottom: 10px;
    }
/* Efek shadow hover pada card */
.hover-shadow:hover {
  box-shadow: 0 0 25px rgba(0, 0, 0, 0.15) !important;
  transform: translateY(-5px);
  transition: 0.3s ease-in-out;
}

/* Untuk navbar transparan */
.navbar {
  backdrop-filter: blur(10px);
  background-color: rgba(255, 255, 255, 0.8) !important;
  transition: background-color 0.3s;
}

  </style>

</head>
<body style="padding-top: 50px;">

<canvas id="snow-canvas"></canvas>

<!-- Navbar -->
 <!-- Transparent Navbar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top bg-transparent">
  <div class="container">
    <a class="navbar-brand fw-bold text-primary" href="#">MyWeb</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
        <li class="nav-item"><a class="nav-link" href="#bidang">Services</a></li>
        <li class="nav-item"><a class="nav-link" href="#kontak">Contact</a></li>
      </ul>
    </div>
    <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
<form class="d-flex me-2" method="GET" action="?#bidang">
  <input class="form-control rounded-pill me-2" type="search" name="cari" placeholder="Cari bidang..." value="<?= isset($_GET['cari']) ? $_GET['cari'] : '' ?>">
  <button class="btn btn-outline-primary rounded-pill me-2" type="submit">Cari</button>

  <?php if (isset($_GET['cari']) && $_GET['cari'] != '') { ?>
    <a href="index.php#bidang" class="btn btn-secondary rounded-pill">Refresh</a>
  <?php } ?>
</form>


    </div>
  </div>
</nav>



<!-- Hero Section -->
<section class="hero text-white text-center d-flex align-items-center justify-content-center">
  <div class="hero-content">
<h1>Temukan Bidang yang Sesuai<br>Dengan Keahlian Anda</h1>
<p class="lead">Gabung bersama kami dan kembangkan potensi terbaik Anda di bidang yang tepat.</p>
 <a href="#bidang" class="btn btn-primary rounded-pill px-4 py-2 mt-4">Jelajahi Bidang</a>
  </div>
</section>

<!-- About Section -->
<section class="container my-5 pt-5" id="bidang">
  <div class="text-center mb-5">
    <h2 class="fw-bold">Bidang Layanan Kami</h2>
    <p class="text-muted">Pilih bidang yang sesuai dengan keahlian atau minat Anda</p>
  </div>
  <div class="row g-4">
    <?php
$where = '';
if (isset($_GET['cari']) && $_GET['cari'] != '') {
  $cari = mysqli_real_escape_string($config, $_GET['cari']);
  $where = "WHERE nama_bidang LIKE '%$cari%'";
}

$query = mysqli_query($config, "SELECT * FROM bidang $where");
while ($data = mysqli_fetch_array($query)) {

      $id = $data['id'];
      $nama = $data['nama_bidang'];
      $gambar = $data['gambar'];
    ?>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 h-100 transition-all hover-shadow">
          <img src="admin/img/bidang/<?= $gambar; ?>" class="card-img-top rounded-top-4" style="height: 200px; object-fit: cover;">
          <div class="card-body text-center">
            <h5 class="card-title mb-3"><?= $nama; ?></h5>
            <div class="d-grid gap-2">
              <button class="btn btn-outline-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#modalDetail<?= $id; ?>">Detail</button>
              <button class="btn btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#modalDaftar<?= $id; ?>">Daftar</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Detail -->
      <div class="modal fade" id="modalDetail<?= $id; ?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content rounded-4">
            <div class="modal-header">
              <h5 class="modal-title">Detail Bidang</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
              <img src="admin/img/bidang/<?= $gambar; ?>" class="img-fluid rounded mb-3" alt="<?= $nama; ?>" style="max-height: 250px; object-fit: cover;">
              <h5 class="fw-bold"><?= $nama; ?></h5>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal Daftar -->
      <div class="modal fade" id="modalDaftar<?= $id; ?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content rounded-4">
            <div class="modal-header">
              <h5 class="modal-title">Form Pendaftaran - <?= $nama; ?></h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST">
              <div class="modal-body">
                <input type="hidden" name="id_bidang" value="<?= $id; ?>">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                  </div>
                  <div class="col-md-6">
                    <label>Tahun Daftar</label>
                    <input type="number" name="tahun_daftar" value="2025" class="form-control" readonly>
                  </div>
                  <div class="col-md-6">
                    <label>Pendidikan (1-5)</label>
                    <input type="number" name="pendidikan" min="1" max="5" class="form-control" required>
                  </div>
                  <div class="col-md-6">
                    <label>Pengalaman Kerja (1-5)</label>
                    <input type="number" name="pengalaman_kerja" min="1" max="5" class="form-control" required>
                  </div>
                  <div class="col-md-6">
                    <label>Keterampilan Komunikasi (1-5)</label>
                    <input type="number" name="keterampilan_komunikasi" min="1" max="5" class="form-control" required>
                  </div>
                  <div class="col-md-6">
                    <label>Problem Solving (1-5)</label>
                    <input type="number" name="problem_solving" min="1" max="5" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" name="submit_daftar" class="btn btn-success rounded-pill w-100">Daftar</button>
              </div>
            </form>
          </div>
        </div>
      </div>

    <?php } ?>
  </div>
</section>


<!-- About Section -->
<!-- Redesigned About Section -->
<section id="about" class="py-5 bg-white">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 mb-4 mb-lg-0">
        <img src="img/about1.png" alt="Tentang Kami" class="img-fluid rounded-4 shadow">
      </div>
      <div class="col-lg-6">
        <h2 class="fw-bold mb-3">Tentang Website Ini</h2>
        <p class="text-muted">Website ini dirancang untuk memudahkan pencari kerja atau individu yang ingin bergabung dalam suatu bidang layanan tertentu. Kami menyediakan informasi lengkap dan sistem pendaftaran yang praktis secara online.</p>
        <p class="text-muted">Dengan tampilan yang modern dan fitur interaktif, pengguna dapat menjelajahi berbagai bidang, melihat detail, dan langsung mendaftar hanya dalam beberapa klik. Semua proses dilakukan secara digital, aman, dan efisien.</p>
        <ul class="list-unstyled mt-4">
          <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Antarmuka yang ramah pengguna</li>
          <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Sistem pendaftaran yang cepat dan mudah</li>
          <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i> Informasi bidang layanan terupdate</li>
        </ul>
      </div>
    </div>
  </div>
</section>



<!-- Contact Section -->
<section  id="kontak" class="py-5" id="contact" style="background: #f8f9fa;">
  <div class="container">
    <div class="text-center mb-4">
      <h2 class="fw-bold">Hubungi Kami</h2>
      <p class="text-muted">Kami siap membantu Anda kapan saja</p>
    </div>
    <div class="row justify-content-center text-center">
      <div class="col-md-4 mb-3">
        <div class="shadow rounded-4 p-4 bg-white h-100">
          <i class="fab fa-whatsapp fa-2x text-success mb-3"></i>
          <h5 class="fw-bold">WhatsApp</h5>
          <p class="text-muted mb-1">+62 812-3456-7890</p>
          <a href="https://wa.me/6281234567890" target="_blank" class="btn btn-outline-success btn-sm rounded-pill">Chat Sekarang</a>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <div class="shadow rounded-4 p-4 bg-white h-100">
          <i class="fas fa-envelope fa-2x text-danger mb-3"></i>
          <h5 class="fw-bold">Email</h5>
          <p class="text-muted mb-1">kontak@layananbidang.com</p>
          <a href="mailto:kontak@layananbidang.com" class="btn btn-outline-danger btn-sm rounded-pill">Kirim Email</a>
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <div class="shadow rounded-4 p-4 bg-white h-100">
          <i class="fas fa-map-marker-alt fa-2x text-primary mb-3"></i>
          <h5 class="fw-bold">Alamat Kantor</h5>
          <p class="text-muted">Jl. Merdeka No. 123, Sumenep, Jawa Timur</p>
        </div>
      </div>
    </div>
  </div>
</section>


<footer class="bg-dark text-white text-center py-4 mt-5">
  <div class="container">
    <p class="mb-1">&copy; <?php echo date("Y"); ?> - Website Bidang Layanan</p>
    <small>Dibuat dengan ❤️ oleh Tim Developer</small>
  </div>
</footer>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Snowfall effect -->
<script>
  const canvas = document.getElementById("snow-canvas");
  const ctx = canvas.getContext("2d");
  let width = canvas.width = window.innerWidth;
  let height = canvas.height = window.innerHeight;
  let flakes = [];

  function SnowFlake() {
    this.x = Math.random() * width;
    this.y = Math.random() * height;
    this.r = Math.random() * 4 + 1;
    this.d = Math.random() * flakes.length;
    this.speed = Math.random() + 0.5;
  }

  for (let i = 0; i < 150; i++) {
    flakes.push(new SnowFlake());
  }

  function drawFlakes() {
    ctx.clearRect(0, 0, width, height);
    ctx.fillStyle = "white";
    ctx.beginPath();
    for (let i = 0; i < flakes.length; i++) {
      let f = flakes[i];
      ctx.moveTo(f.x, f.y);
      ctx.arc(f.x, f.y, f.r, 0, Math.PI * 2, true);
    }
    ctx.fill();
    moveFlakes();
  }

  function moveFlakes() {
    for (let i = 0; i < flakes.length; i++) {
      let f = flakes[i];
      f.y += f.speed;
      if (f.y > height) {
        flakes[i] = new SnowFlake();
        flakes[i].y = 0;
      }
    }
  }

  setInterval(drawFlakes, 25);
</script>

</body>
</html>
<?php

if (isset($_POST['submit_daftar'])) {
    $id_bidang = $_POST['id_bidang'];
    $nama = $_POST['nama'];
    $tahun = $_POST['tahun_daftar'];
    $pendidikan = $_POST['pendidikan'];
    $pengalaman = $_POST['pengalaman_kerja'];
    $komunikasi = $_POST['keterampilan_komunikasi'];
    $solving = $_POST['problem_solving'];

    $insert = mysqli_query($config, "INSERT INTO calon_karyawan (nama, tahun_daftar, pendidikan, pengalaman_kerja, keterampilan_komunikasi, problem_solving) 
    VALUES ('$nama', '$tahun', '$pendidikan', '$pengalaman', '$komunikasi', '$solving')");
    $calon=mysqli_query($config,"SELECT * FROM calon_karyawan order by id desc");
    $data_calon=mysqli_fetch_assoc($calon);
    $id_calon=$data_calon['id'];
    $simpan=mysqli_query($config,"INSERT INTO kandidat_bidang VALUES ('$id_calon','$id_bidang')");

    if ($simpan) {
        echo "<script>
        Swal.fire({title: 'Tambah Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
            document.location.href='index.php';
            }
        })</script>";
    } else {
        echo "<script>
        Swal.fire({title: 'Tambah Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
        }).then((result) => {if (result.value){
            document.location.href='index.php';
            }
        })</script>";
    }
}
?>
