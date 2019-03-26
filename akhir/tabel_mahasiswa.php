<?php
  // buat koneksi dengan database mysql
  $link = mysqli_connect("localhost","root","","ypjkk");
  
  // ambil nama mahasiswa dari query string
  $nama_mahasiswa = $_GET["n"];
  
  // ambil dara dari tabel mahasiswa
  $query  = "SELECT * FROM daftarsiswa WHERE ekstrakurikuler = '$nama_mahasiswa' ";
  $result = mysqli_query($link, $query);

  //buat perulangan untuk element tabel dari data mahasiswa
  while($data = mysqli_fetch_row($result))
  { 
    // konversi date MySQL (yyyy-mm-dd) menjadi dd-mm-yyyy
    $tanggal_php = strtotime($data[3]);
    $tanggal = date("d - m - Y", $tanggal_php);
    
    // tampilkan data dalam bentuk tabel HTML
    echo "<table border='1'>";
    echo "<tr><td>NIS</td><td>$data[0]</td></tr>";
    echo "<tr><td>Nama</td><td>$data[1]</td>";
    echo "<tr><td>Kelas</td><td>$data[2]</td>";
    echo "<tr><td>Asal</td><td>$data[3]</td>";
    echo "<tr><td>Ekstrakurikuler</td><td>$data[4]</td>";
    echo "</table></br>";
	
  }
  
?>