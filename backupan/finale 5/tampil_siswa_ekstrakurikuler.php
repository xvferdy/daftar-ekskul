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
    $ekstrakurikuler = htmlentities(strip_tags(trim($_GET["ekstrakurikuler"])));
    
    // filter untuk $nama untuk mencegah sql injection
    $ekstrakurikuler = mysqli_real_escape_string($link,$ekstrakurikuler);
    
    // buat query pencarian
    $query  = "SELECT * FROM siswa WHERE ekstrakurikuler LIKE '%$ekstrakurikuler%' ";
    $query .= "ORDER BY ekstrakurikuler ASC";
    
    // buat pesan
    $pesan = "Hasil pencarian untuk nama <b>\"$ekstrakurikuler\" </b>:";
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
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
    background-color: #E6E6FA;

}

li {
  float: left;
}

li a {
  display: block;
  color: black;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover {
  background-color: #B0C4DE;
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
	<li><a href="ekstra_kurikuler.php">Ekstra Kurikuler</a></li>
    <li><a href="tampil_siswa.php">Tampil</a></li>
    <li><a href="tambah_siswa.php">Tambah</a>
    <li><a href="hapus_siswa.php">Hapus</a></li>
	<li><a href="tambah_ekstrakurikuler.php">Tambah Ekstrakurikuler</a></li>
	<li><a href="tampil_ekstrakurikuler.php">Tampil Ekstrakurikuler</a></li>
	<li><a href="tampil_siswa_ekstrakurikuler.php">hidden</a></li>
    <li><a href="logout.php">Logout</a>
  </ul>
  </nav>
  <form id="search" action="tampil_siswa_ekstrakurikuler.php" method="get">
    <p>
      <label for="nis">Nama : </label> 
      <input type="text" name="ekstrakurikuler" id="ekstrakurikuler" placeholder="search..." >
      <input type="submit" name="submit" value="Search">
    </p>
  </form>
<h2>DATA SISWA</h2>
<?php
  // tampilkan pesan jika ada
  if (isset($pesan)) {
      echo "<div class=\"pesan\">$pesan</div>";
  }
    
?>

<div class = "sidebar">
<ul>
<li><a href="exsepak_bola.php" ><i>sepak bola</i></a></li>
<li><a href="exbulu_tangkis.php"><i>bulutangkis</i></a></li>
<li><a href="exrenang.php"><i>renang</i></a></li>
<li><a href="exbasket.php"><i>basket</i></a></li>
<li><a href="extata_boga.php"><i>tata boga</i></a></li>
<li><a href="exbahasa_asing.php"><i>bahasa asing</i></a></li>
<li><a href="exklub_matematika.php"><i>klub matematika</i></a></li>
<li><a href="exklub_sains.php"><i>klub sains</i></a></li>
<li><a href="exkomputer.php"><i>komputer</i></a></li>
<li><a href="excatur.php"><i>catur</i></a></li>
  </ul>
  </div>

 <table border="1">
  <tr>
  <th>NIS</th>
  <th>Nama</th>
  <th>Kelas</th>
  <th>Asal</th>
  <th>Ekstrakurikuler</th>
  </tr>
  <?php
  // jalankan query
  $result = mysqli_query($link, $query);
  
  if(!$result){
      die ("Query Error: ".mysqli_errno($link).
           " - ".mysqli_error($link));
  }
  
  //buat perulangan untuk element tabel dari data siswa
  while($data = mysqli_fetch_assoc($result))
  { 
    echo "<tr>";
    echo "<td>$data[nis]</td>";
    echo "<td>$data[nama]</td>";
    echo "<td>$data[kelas]</td>";
    echo "<td>$data[asal]</td>";
    echo "<td>$data[ekstrakurikuler]</td>";
    echo "</tr>";
  }
  
  // bebaskan memory 
  mysqli_free_result($result);
  
  // tutup koneksi dengan database mysql
  mysqli_close($link);
  ?>
  </table>
  
  

  
  
  <div id="footer">
    Copyright © <?php echo date("Y"); ?> YPJ Kuala-Kencana
  </div>
</div>
</body>
</html>