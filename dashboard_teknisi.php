<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
include "koneksi.php";

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: white;
            padding: 15px;
            position: fixed;
            width: 220px;
        }
        .sidebar a, .sidebar .dropdown-toggle {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
            border-radius: 5px;
        }
        .sidebar a:hover, .sidebar .dropdown-toggle:hover {
            background-color: red;
        }
        .content {
            margin-left: 240px;
            padding: 20px;
        }
        .dropdown-menu {
            background-color: #495057;
            border: none;
        }
        .dropdown-menu a {
            color: white;
        }
        .dropdown-menu a:hover {
            background-color: red;
        }
    </style>
</head>
<body>
<div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <h4>Admin</h4>
            <a href="dashboard.php"></a>
            <div class="dropdown">
            <a class="dropdown-item" href="halaman_pelanggan.php">Data Pelanggan</a>
            <a class="dropdown-item" href="halaman_aktivitas.php">Data Aktivitas Kunjungan</a>
            <a href="tracking_kunjungan.php">Penjadwalan Ulang Kunjungan</a>
            </div>    
            <a href="logout.php" class="btn btn-outline-light mt-3">Logout</a>
        </div>
        <!-- Main Content -->
        <div class="content">
            <h1>Selamat Datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
