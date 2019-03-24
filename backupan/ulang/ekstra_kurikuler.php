<?php
  // periksa apakah user sudah login, cek kehadiran session name 
  // jika tidak ada, redirect ke login.php
  session_start();
  if (!isset($_SESSION["nama"])) {
     header("Location: login.php");
  }

  // buka koneksi dengan MySQL
     include("koneksi.php");
  
  // ambil pesan jika ada  
  if (isset($_GET["pesan"])) {
      $pesan = $_GET["pesan"];
  }
     
  // cek apakah form telah di submit
  // berasal dari form pencairan, siapkan query 
  if (isset($_GET["submit"])) {
      
    // ambil nilai nama
    $nama = htmlentities(strip_tags(trim($_GET["nama"])));
    
    // filter untuk $nama untuk mencegah sql injection
    $nama = mysqli_real_escape_string($link,$nama);
    
    // buat query pencarian
    $query  = "SELECT * FROM siswa WHERE nama LIKE '%$nama%' ";
    $query .= "ORDER BY nama ASC";
    
    // buat pesan
    $pesan = "Hasil pencarian untuk nama <b>\"$nama\" </b>:";
  } 
  else {
  // bukan dari form pencairan
  // siapkan query untuk menampilkan seluruh data dari tabel siswa
    $query = "SELECT * FROM siswa ORDER BY nama ASC";
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>YPJ School | Selamat datang</title>
    <style>


div.gallery {
  margin: 5px;
  border: 1px solid #ccc;
  float: left;
  width: 180px;
}

div.gallery:hover {
  border: 1px solid #777;
}

div.gallery img {
  width: 100%;
  height: 120px;
}

div.desc {
  padding: 7px;
  text-align: center;
  background: rgb(231, 232, 226);
}

	
  </style>
  
  <link href="style.css" rel="stylesheet" >
  <link rel="icon" href="ypj2.png" type="image/png" >
</head>
<body>
<div class="container">
<div id="header">
  <h1 id="logo">Sistem Informasi <span>Ekstrakurikuler</span></h1>
  <p id="tanggal"><?php echo date("d M Y"); ?></p>
</div>
<hr>
  <nav>
  <ul>
	<li><a href="ekstra_kurikuler.php">Ekstrakurikuler</a></li>
    <li><a href="tampil_siswa.php">Tampil</a></li>
    <li><a href="tambah_siswa.php">Tambah</a>
    <li><a href="hapus_siswa.php">Hapus</a></li>
    <li><a href="logout.php">Logout</a>
  </ul>
  </nav>
  <form id="search" action="tampil_siswa.php" method="get">
    <p>
      <label for="nis">Nama : </label> 
      <input type="text" name="nama" id="nama" placeholder="search..." >
      <input type="submit" name="submit" value="Search">
    </p>
  </form>
<h2>DAFTAR EKSTRAKURIKULER</h2>
<?php
  // tampilkan pesan jika ada
  if (isset($pesan)) {
      echo "<div class=\"pesan\">$pesan</div>";
  }
?>

<div class="gallery">
  <a href="exsepak_bola.php">
    <img src="gambar_ekskul/sepak_bola.jpg" title="SEPAK BOLA" alt="SEPAK BOLA" width="600" height="400">
  </a>
  <div class="desc">Sepak bola</div>
</div>

<div class="gallery">
  <a href="exbulu_tangkis.php">
    <img src="gambar_ekskul/bulu_tangkis.jpg" title="BULUTANGKIS" alt="BULUTANGKIS" width="600" height="400">
  </a>
  <div class="desc">Bulutangkis</div>
</div>

<div class="gallery">
  <a href="exrenang.php">
    <img src="gambar_ekskul/renang.jpg" title="RENANG" alt="RENANG" width="600" height="400">
  </a>
  <div class="desc">Renang</div>
</div>

<div class="gallery">
  <a href="exbasket.php">
    <img src="gambar_ekskul/basket.jpg" title="BASKET" alt="BASKET" width="600" height="400">
  </a>
  <div class="desc">Basket</div>
</div>

<div class="gallery">
  <a href="extata_boga.php">
    <img src="gambar_ekskul/tata_boga.jpg" title="TATA BOGA" alt="TATA BOGA" width="600" height="400">
  </a>
  <div class="desc">Tata Boga</div>
</div>

<div class="gallery">
  <a href="exbahasa_asing.php">
    <img src="gambar_ekskul/bahasa_asing.jpg" title="BAHASA ASING" alt="SEPAK BOLA" width="600" height="400">
  </a>
  <div class="desc">Bahasa Asing</div>
</div>

<div class="gallery">
  <a href="exklub_matematika.php">
    <img src="gambar_ekskul/klub_matematika.jpg" title="KLUB MATEMATIKA" alt="KLUB MATEMATIKA" width="600" height="400">
  </a>
  <div class="desc">Klub Matematika</div>
</div>

<div class="gallery">
  <a href="exklub_sains.php">
    <img src="gambar_ekskul/klub_sains.jpg" title="KLUB SAINS" alt="KLUB SAINS" width="600" height="400">
  </a>
  <div class="desc">Klub Sains</div>
</div>

<div class="gallery">
  <a href="exkomputer.php">
    <img src="gambar_ekskul/komputer.jpg" title="KOMPUTER" alt="KOMPUTER" width="600" height="400">
  </a>
  <div class="desc">Komputer</div>
</div>

<div class="gallery">
  <a href="excatur.php">
    <img src="gambar_ekskul/catur.jpg" title="CATUR" alt="CATUR" width="600" height="400">
  </a>
  <div class="desc">Catur</div>
</div>



  <div id="footer">
    Copyright © <?php echo date("Y"); ?> YPJ Kuala-Kencana
  </div>
</div>
</body>
</html>