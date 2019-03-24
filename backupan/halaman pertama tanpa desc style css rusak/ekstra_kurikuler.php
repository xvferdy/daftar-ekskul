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
    $query  = "SELECT * FROM extrakurikuler WHERE nama LIKE '%$nama%' ";
    $query .= "ORDER BY nama ASC";
    
    // buat pesan
    $pesan = "Hasil pencarian untuk nama <b>\"$nama\" </b>:";
  } 
  else {
  // bukan dari form pencairan
  // siapkan query untuk menampilkan seluruh data dari tabel extrakurikuler
    $query = "SELECT * FROM extrakurikuler ORDER BY nama ASC";
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>YPJ School | Selamat datang</title>
    <style>

    .gallery{
      background: rgb(231, 232, 226);
      width: 880px;
      margin: 10px auto;	  
    }

    img {		
	width: 132.8px;
	height: 132.8px;
      border: 10px solid white;
      margin: 10px;
    }
	

	
  </style>
  
  <link href="style.css" rel="stylesheet" >
  <link rel="icon" href="ypj2.png" type="image/png" >
</head>
<body>
<div class="container">
<div id="header">
  <h1 id="logo">Sistem Informasi <span>Extrakurikuler</span></h1>
  <p id="tanggal"><?php echo date("d M Y"); ?></p>
</div>
<hr>
  <nav>
  <ul>
	<li><a href="ekstra_kurikuler.php">Ekstra Kurikuler</a></li>
    <li><a href="tampil_siswa.php">Tampil</a></li>
    <li><a href="tambah_siswa.php">Tambah</a>
    <li><a href="hapus_siswa.php">Hapus</a></li>
    <li><a href="logout.php">Logout</a>
  </ul>
  </nav>
  <form id="search" action="tampil_siswa.php" method="get">
    <p>
      <label for="nim">Nama : </label> 
      <input type="text" name="nama" id="nama" placeholder="search..." >
      <input type="submit" name="submit" value="Search">
    </p>
  </form>
<h2>DAFTAR EKSTRA KURIKULER</h2>
<?php
  // tampilkan pesan jika ada
  if (isset($pesan)) {
      echo "<div class=\"pesan\">$pesan</div>";
  }
?>
<div class="gallery">

	<a href="exsepak_bola.php"><img title="SEPAK BOLA" src="gambar_ekskul/sepak_bola.jpg"></a>

	<a href="exbulu_tangkis.php"><img title="BULU TANGKIS" src="gambar_ekskul/bulu_tangkis.jpg"></a>
	
	<a href="exrenang.php"><img title="RENANG" src="gambar_ekskul/renang.jpg"></a>

	<a href="exbasket.php"><img title="BASKET" src="gambar_ekskul/basket.jpg"></a>
	
	<a href="extata_boga.php"><img title="TATA BOGA" src="gambar_ekskul/tata_boga.jpg"></a>
		
	<a href="exbahasa_asing.php"><img title="BAHASA ASING" src="gambar_ekskul/bahasa_asing.jpg"></a>
			
	<a href="exklub_matematika.php"><img title="KLUB MATEMATIKA" src="gambar_ekskul/klub_matematika.jpg"></a>
				
	<a href="exklub_sains.php"><img title="KLUB SAINS" src="gambar_ekskul/klub_sains.jpg"></a>
					
	<a href="exkomputer.php"><img title="KOMPUTER" src="gambar_ekskul/komputer.jpg"></a>
						
	<a href="excatur.php"><img title="CATUR" src="gambar_ekskul/catur.jpg"></a>
			

</div>

  <div id="footer">
    Copyright © <?php echo date("Y"); ?> YPJ Kuala-Kencana
  </div>
</div>
</body>
</html>