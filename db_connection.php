<?php
// File koneksi database (db_connection.php)
$host = 'localhost';
$dbname = 'projek_ptc';
$user = 'root';
$pass = '';

// Membuat koneksi mysqli
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Periksa apakah koneksi berhasil
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
