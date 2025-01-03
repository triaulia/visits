<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pelanggan = htmlspecialchars($_POST["id_pelanggan"]);
    $tanggal_kunjungan = htmlspecialchars($_POST["tanggal_kunjungan"]);
    $teknisi = htmlspecialchars($_POST["teknisi"]);
    $deskripsi_kunjungan = htmlspecialchars($_POST["deskripsi_kunjungan"]);
    $status_kunjungan = htmlspecialchars($_POST["status_kunjungan"]);
    
    // Upload gambar
    $gambar = "";
    if (!empty($_FILES["gambar"]["name"])) {
        $gambar = time() . "_" . basename($_FILES["gambar"]["name"]);
        $target_file = "uploads/" . $gambar;
        if (!move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            echo "<div class='alert alert-danger'>Gagal mengupload gambar.</div>";
        }
    }

    $sql = "INSERT INTO aktivitas_kunjungan (id_pelanggan, tanggal_kunjungan, teknisi, deskripsi_kunjungan, status_kunjungan, gambar) 
            VALUES ('$id_pelanggan', '$tanggal_kunjungan', '$teknisi', '$deskripsi_kunjungan', '$status_kunjungan', '$gambar')";
    
    if (mysqli_query($kon, $sql)) {
        echo "<div class='alert alert-success'>Data berhasil ditambahkan.</div>";
        header("Location: halaman_aktivitas.php");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Gagal menambahkan data.</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Aktivitas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <style>
        /* Body styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        /* Container styling */
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 30px auto;
            max-width: 600px;
        }

        /* Header styling */
        h4 {
            color: #343a40;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Button styling */
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: #ffffff;
            font-weight: bold;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            color: #ffffff;
            font-weight: bold;
        }

        .btn-primary:hover,
        .btn-secondary:hover {
            opacity: 0.9;
        }

        /* Form styling */
        .form-group label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 5px;
        }

        /* Responsive layout */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            h4 {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h4 class="text-center mt-4">Tambah Aktivitas Kunjungan</h4>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>ID Pelanggan</label>
            <input type="text" name="id_pelanggan" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Tanggal Kunjungan</label>
            <input type="date" name="tanggal_kunjungan" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Teknisi</label>
            <input type="text" name="teknisi" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Deskripsi Kunjungan</label>
            <textarea name="deskripsi_kunjungan" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label>Status Kunjungan</label>
            <select name="status_kunjungan" class="form-control">
                <option value="Pending">Pending</option>
                <option value="Completed">Completed</option>
                <option value="Canceled">Canceled</option>
            </select>
        </div>
        <div class="form-group">
            <label>Upload Gambar</label>
            <input type="file" name="gambar" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="halaman_aktivitas.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
