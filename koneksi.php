<?php
// File: koneksi.php
$host = "localhost";  // Sesuaikan dengan host database Anda
$user = "root";       // Sesuaikan dengan username database
$pass = "";           // Sesuaikan dengan password database
$dbname = "visit_teknisi"; // Sesuaikan dengan nama database

// Buat koneksi
$kon = mysqli_connect($host, $user, $pass, $dbname);

// Periksa koneksi
if (!$kon) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
