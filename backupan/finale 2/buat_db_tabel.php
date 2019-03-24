<?php
  // buat koneksi dengan database mysql
  $dbhost = "localhost";
  $dbuser = "root";
  $dbpass = "";
  $link = mysqli_connect($dbhost,$dbuser,$dbpass);
  
  //periksa koneksi, tampilkan pesan kesalahan jika gagal
  if(!$link){
    die ("Koneksi dengan database gagal: ".mysqli_connect_errno().
         " - ".mysqli_connect_error());
  }
  
  //buat database ypjkk jika belum ada
  $query = "CREATE DATABASE IF NOT EXISTS ypjkk";
  $result = mysqli_query($link, $query);
  
  if(!$result){
    die ("Query Error: ".mysqli_errno($link).
         " - ".mysqli_error($link));
  }
  else {
    echo "Database <b>'ypjkk'</b> berhasil dibuat... <br>";
  }
  
  //pilih database ypjkk
  $result = mysqli_select_db($link, "ypjkk");
  
  if(!$result){
    die ("Query Error: ".mysqli_errno($link).
         " - ".mysqli_error($link));
  }
  else {
    echo "Database <b>'ypjkk'</b> berhasil dipilih... <br>";
  }
 
  // cek apakah tabel extrakurikuler sudah ada. jika ada, hapus tabel
  $query = "DROP TABLE IF EXISTS extrakurikuler";
  $hasil_query = mysqli_query($link, $query);
  
  if(!$hasil_query){
    die ("Query Error: ".mysqli_errno($link).
         " - ".mysqli_error($link));
  }
  else {
    echo "Tabel <b>'extrakurikuler'</b> berhasil dihapus... <br>";
  }
  
  // buat query untuk CREATE tabel extrakurikuler

  $query  = "CREATE TABLE extrakurikuler (nis CHAR(8), nama VARCHAR(100), "; 
  $query .= "kelas CHAR(10), asal VARCHAR(50), ";
  $query .= "extrakurikuler VARCHAR(50), ";
  $query .= "PRIMARY KEY (nis))";

  $hasil_query = mysqli_query($link, $query);
  
  if(!$hasil_query){
      die ("Query Error: ".mysqli_errno($link).
           " - ".mysqli_error($link));
  }
  else {
    echo "Tabel <b>'extrakurikuler'</b> berhasil dibuat... <br>";
  }
  
  // buat query untuk INSERT data ke tabel extrakurikuler
  $query  = "INSERT INTO extrakurikuler VALUES "; 
  $query .= "('14405021', 'Sadrak Wamafma',     '4B', 'Fakfak',   'Sepak Bola' ),";
  $query .= "('17081034', 'Ucok Benedik',       '4A', 'Batak',    'Bulu tangkis'),";
  $query .= "('11013021', 'Anti',               '4B', 'Bugis',    'Renang'),";
  $query .= "('15612086', 'Reymond Timbuleng',  '4A', 'Menado',   'Basket' ),";
  $query .= "('13033017', 'Pamela Rumpeday',    '4C', 'Jayapura', 'Permainan Tradisional'),";
  $query .= "('11044017', 'Dewi Lempoy',        '4A', 'Menado',   'Budaya Papua'),";
  $query .= "('15032012', 'Ferdy Pongbubun',    '4B', 'Toraja',   'Tata Boga'),";
  $query .= "('13089018', 'Adit Jayakusuma',    '4A', 'Semarang', 'Bahasa Asing'),";
  $query .= "('13093419', 'Ayu Rahayu',         '4A', 'Jakarta',  'Fotografi IPAD'),";
  $query .= "('13093619', 'Hubert Kiwak',       '4A', 'Biak',     'Klub Matematika '),";
  $query .= "('13893518', 'Boy Dimara',         '4C', 'Manokwari','Klub Sains'),";
  $query .= "('13663716', 'Dian',               '4B', 'Palu',     'Komputer'),";
  $query .= "('13043414', 'Fauzi Fauzan',       '4A', 'Bandung',  'Catur'),";
  $query .= "('13493444', 'Patricia Magal',     '4C', 'Merauke',  'Sepak Bola'),";
  $query .= "('13056415', 'Hengki Kayame',      '4A', 'Paniai',   'Sepak bola'),";
  $query .= "('13098417', 'Petrus Takimai',     '4A', 'Asmat',    'Bulu Tangkis'),";
  $query .= "('13093411', 'Bayu Skak',          '4A', 'Semarang', 'Renang'),";
  $query .= "('13063266', 'Kencana Masnandifu', '4C', 'Biak',     'Renang') ";






  $hasil_query = mysqli_query($link, $query);
  
  if(!$hasil_query){
      die ("Query Error: ".mysqli_errno($link).
           " - ".mysqli_error($link));
  }
  else {
    echo "Tabel <b>'extrakurikuler'</b> berhasil diisi... <br>";
  }
    
  // cek apakah tabel pakguru sudah ada. jika ada, hapus tabel
  $query = "DROP TABLE IF EXISTS pakguru";
  $hasil_query = mysqli_query($link, $query);
  
  if(!$hasil_query){
    die ("Query Error: ".mysqli_errno($link).
         " - ".mysqli_error($link));
  }
  else {
    echo "Tabel <b>'pakguru'</b> berhasil dihapus... <br>";
  }
  
  // buat query untuk CREATE tabel pakguru
  $query  = "CREATE TABLE pakguru (username VARCHAR(50), password CHAR(40))"; 
  $hasil_query = mysqli_query($link, $query);
  
  if(!$hasil_query){
      die ("Query Error: ".mysqli_errno($link).
           " - ".mysqli_error($link));
  }
  else {
    echo "Tabel <b>'pakguru'</b> berhasil dibuat... <br>";
  }
  
  // buat username dan password untuk pakguru
  $username = "pakberli";
  $password = sha1("rahasia");
  
  // buat query untuk INSERT data ke tabel pakguru
  $query  = "INSERT INTO pakguru VALUES ('$username','$password')"; 

  $hasil_query = mysqli_query($link, $query);
  
  if(!$hasil_query){
      die ("Query Error: ".mysqli_errno($link).
           " - ".mysqli_error($link));
  }
  else {
    echo "Tabel <b>'pakguru'</b> berhasil diisi... <br>";
  }
  
  // tutup koneksi dengan database mysql
  mysqli_close($link);
?>