<?php
  // periksa apakah user sudah login, cek kehadiran session name 
  // jika tidak ada, redirect ke login.php
  session_start();
  if (!isset($_SESSION["nama"])) {
     header("Location: login.php");
  }
  
  // buka koneksi dengan MySQL
  include("koneksi.php");
  
  // cek apakah form telah di submit
  if (isset($_POST["submit"])) {
    // form telah disubmit, proses data
    
    // ambil semua nilai form
    $kode = htmlentities(strip_tags(trim($_POST["kode"])));
    $ekstrakurikuler = htmlentities(strip_tags(trim($_POST["ekstrakurikuler"])));

    
    // siapkan variabel untuk menampung pesan error
    $pesan_error="";
    
    // cek apakah "nis" sudah diisi atau tidak
    if (empty($kode)) {
      $pesan_error .= "kode belum diisi <br>";
    }

    
    // cek ke database, apakah sudah ada nomor NIS yang sama    
    // filter data $nis
    $kode = mysqli_real_escape_string($link,$kode);
    $query = "SELECT * FROM ekstrakurikuler WHERE kode='$kode'";
    $hasil_query = mysqli_query($link, $query);
	
    // cek jumlah record (baris), jika ada, $nis tidak bisa diproses
    $jumlah_data = mysqli_num_rows($hasil_query);
     if ($jumlah_data >= 1 ) {
       $pesan_error .= "kode yang sama sudah digunakan <br>";  
    }

		    // cek ke database, apakah sudah ada nomor ekstrakurikuler yang sama    
    // filter data $nis
    $kode = mysqli_real_escape_string($link,$kode);
    $query = "SELECT * FROM ekstrakurikuler WHERE ekstrakurikuler='$ekstrakurikuler'";
    $hasil_query = mysqli_query($link, $query);
	
	    // cek jumlah record (baris), jika ada, $nis tidak bisa diproses
    $jumlah_data = mysqli_num_rows($hasil_query);
     if ($jumlah_data >= 1 ) {
       $pesan_error .= "ekstrakurikuler yang sama sudah digunakan <br>";  
    }
  
	
    // cek apakah "nama" sudah diisi atau tidak
    if (empty($ekstrakurikuler)) {
      $pesan_error .= "Nama belum diisi <br>";
    }

    
     
    // jika tidak ada error, input ke database
    if ($pesan_error === "") {
      
      // filter semua data
      $kode = mysqli_real_escape_string($link,$kode);
      $ekstrakurikuler = mysqli_real_escape_string($link,$ekstrakurikuler );
      
      
      //buat dan jalankan query INSERT
      $query = "INSERT INTO ekstrakurikuler VALUES ";
      $query .= "('$kode','$ekstrakurikuler')";

      $result = mysqli_query($link, $query);
      
      //periksa hasil query
      if($result) {
      // INSERT berhasil, redirect ke tampil_siswa.php + pesan
        $pesan = "siswa dengan nama = \"<b>$kode</b>\" sudah berhasil di tambah";
        $pesan = urlencode($pesan);
        header("Location: tampil_siswa.php?pesan={$pesan}");
      } 
      else { 
      die ("Query gagal dijalankan: ".mysqli_errno($link).
           " - ".mysqli_error($link));
      }    
    }
  }
  else {
    // form belum disubmit atau halaman ini tampil untuk pertama kali 
    // berikan nilai awal untuk semua isian form
    $pesan_error = "";
    $kode = "";
    $ekstrakurikuler = "";

  }

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>YPJ School | Selamat datang</title>
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
      <label for="nama">Nama : </label> 
      <input type="text" name="nama" id="nama" placeholder="search..." >
      <input type="submit" name="submit" value="Search">
    </p>
  </form>
<h2>Ekstrakurikuler</h2>
<?php
  // tampilkan error jika ada
  if ($pesan_error !== "") {
      echo "<div class=\"error\">$pesan_error</div>";
  }
?>
<form id="form_siswa" action="tambah_ekstrakurikuler.php" method="post">
<fieldset>
<legend>Ekstrakurikuler</legend>
  <p>
    <label for="kode">KODE : </label> 
    <input type="text" name="kode" id="kode" value="<?php echo $kode ?>">
  </p>
  <p>
    <label for="ekstrakurikuler">Ekstrakurikuler : </label> 
    <input type="text" name="ekstrakurikuler" id="ekstrakurikuler" value="<?php echo $ekstrakurikuler ?>">
  </p>

  
</fieldset>
  <br>
  <p>
    <input type="submit" name="submit" value="Tambah Data">
  </p>
</form> 
  
  <div id="footer">
    Copyright © <?php echo date("Y"); ?> YPJ Kuala-Kencana
  </div>
  
</div>

</body>
</html>
<?php
  // tutup koneksi dengan database mysql
  mysqli_close($link);
?>