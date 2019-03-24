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
    $nim = htmlentities(strip_tags(trim($_POST["nim"])));
    $nama = htmlentities(strip_tags(trim($_POST["nama"])));
    $kelas = htmlentities(strip_tags(trim($_POST["kelas"])));
    $asal = htmlentities(strip_tags(trim($_POST["asal"])));
    $extrakurikuler = htmlentities(strip_tags(trim($_POST["extrakurikuler"])));

    
    // siapkan variabel untuk menampung pesan error
    $pesan_error="";
    
    // cek apakah "nim" sudah diisi atau tidak
    if (empty($nim)) {
      $pesan_error .= "NIM belum diisi <br>";
    }
    // NIM harus angka dengan 8 digit
    elseif (!preg_match("/^[0-9]{8}$/",$nim) ) {
      $pesan_error .= "NIM harus berupa 8 digit angka <br>";
    }
    
    // cek ke database, apakah sudah ada nomor NIM yang sama    
    // filter data $nim
    $nim = mysqli_real_escape_string($link,$nim);
    $query = "SELECT * FROM extrakurikuler WHERE nim='$nim'";
    $hasil_query = mysqli_query($link, $query);
  
    // cek jumlah record (baris), jika ada, $nim tidak bisa diproses
    $jumlah_data = mysqli_num_rows($hasil_query);
     if ($jumlah_data >= 1 ) {
       $pesan_error .= "NIM yang sama sudah digunakan <br>";  
    }

    // cek apakah "nama" sudah diisi atau tidak
    if (empty($nama)) {
      $pesan_error .= "Nama belum diisi <br>";
    }
    
    // cek apakah "kelas" sudah diisi atau tidak
    if (empty($kelas)) {
      $pesan_error .= "Kelas belum diisi <br>";
    }
	
	// cek apakah "asal" sudah diisi atau tidak
    if (empty($asal)) {
      $pesan_error .= "asal belum diisi <br>";
    }
              
    // siapkan variabel untuk menggenerate pilihan extrakurikuler
    $select_sepak_bola=""; $select_voli=""; $select_futsal="";
    $select_berenang=""; $select_band=""; $select_pramuka="";
    
    switch($extrakurikuler) {
     case "Sepak Bola"     : $select_sepak_bola     = "selected";  break;
     case "Voli"      : $select_voli      = "selected";  break;
     case "Futsal"    : $select_futsal    = "selected";  break;
     case "Berenang"  : $select_berenang  = "selected";  break;
     case "Band"      : $select_band      = "selected";  break;
     case "Pramuka"   : $select_pramuka   = "selected";  break;
    } 
    
     
    // jika tidak ada error, input ke database
    if ($pesan_error === "") {
      
      // filter semua data
      $nim = mysqli_real_escape_string($link,$nim);
      $nama = mysqli_real_escape_string($link,$nama );
      $kelas = mysqli_real_escape_string($link,$kelas);
      $asal = mysqli_real_escape_string($link,$asal);
      $extrakurikuler = mysqli_real_escape_string($link,$extrakurikuler);
      
      
      //buat dan jalankan query INSERT
      $query = "INSERT INTO extrakurikuler VALUES ";
      $query .= "('$nim', '$nama', '$kelas', ";
      $query .= "'$asal','$extrakurikuler')";

      $result = mysqli_query($link, $query);
      
      //periksa hasil query
      if($result) {
      // INSERT berhasil, redirect ke tampil_siswa.php + pesan
        $pesan = "siswa dengan nama = \"<b>$nama</b>\" sudah berhasil di tambah";
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
    $nim = "";
    $nama = "";
    $kelas = "";
    $select_sepak_bola=""; 
    $select_voli=""; $select_futsal="";
    $select_berenang=""; $select_band=""; $select_pramuka="";
    $asal = "";
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
<h2>Tambah Data siswa</h2>
<?php
  // tampilkan error jika ada
  if ($pesan_error !== "") {
      echo "<div class=\"error\">$pesan_error</div>";
  }
?>
<form id="form_siswa" action="tambah_siswa.php" method="post">
<fieldset>
<legend>Siswa Baru</legend>
  <p>
    <label for="nim">NIM : </label> 
    <input type="text" name="nim" id="nim" value="<?php echo $nim ?>"> (8 digit angka)
  </p>
  <p>
    <label for="nama">Nama : </label> 
    <input type="text" name="nama" id="nama" value="<?php echo $nama ?>">
  </p>
  <p>
    <label for="kelas">Kelas : </label> 
    <input type="text" name="kelas" id="kelas" 
    value="<?php echo $kelas ?>">
  </p>
  <p>
    <label for="extrakurikuler" >Extrakurikuler : </label> 
      <select name="extrakurikuler" id="extrakurikuler">
        <option value="Sepak bola" <?php echo $select_sepak_bola ?>>
        Sepak Bola </option>
        <option value="Voli" <?php echo $select_voli ?>>
        Voli</option>
        <option value="Futsal" <?php echo $select_futsal ?>>
        Futsal</option>
        <option value="Berenang" <?php echo $select_berenang ?>>
        Berenang</option>
        <option value="Band" <?php echo $select_band ?>>
        Band</option>
        <option value="Pramuka" <?php echo $select_pramuka ?>>
        Pramuka</option>
      </select>
  </p>
  <p>
    <label for="asal">Asal : </label> 
    <input type="text" name="asal" id="asal" value="<?php echo $asal ?>">
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