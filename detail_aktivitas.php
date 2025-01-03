<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <title>Detail Aktivitas Kunjungan</title>
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <span class="navbar-brand mb-0 h1">Telkom Indonesia</span>
    <a href="logout.php" class="btn btn-outline-light">Logout</a>
</nav>

<div class="container mt-4">
    <h4 class="text-center">Detail Aktivitas Kunjungan</h4>

    <?php
    session_start();
    include "koneksi.php";

    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit;
    }

    if (isset($_GET['id'])) {
        $id = htmlspecialchars($_GET['id']);
        $query = "SELECT ak.*, p.nama_pelanggan, p.alamat_pelanggan, p.telepon_pelanggan 
                  FROM aktivitas_kunjungan ak 
                  JOIN pelanggan p ON ak.id_pelanggan = p.id 
                  WHERE ak.id = $id";
        $result = mysqli_query($kon, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);
        } else {
            echo "<div class='alert alert-danger'>Data tidak ditemukan.</div>";
            exit;
        }
    } else {
        echo "<div class='alert alert-danger'>ID tidak valid.</div>";
        exit;
    }
    ?>

    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td><?php echo htmlspecialchars($data['id']); ?></td>
        </tr>
        <tr>
            <th>Nama Pelanggan</th>
            <td><?php echo htmlspecialchars($data['nama_pelanggan']); ?></td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td><?php echo htmlspecialchars($data['alamat_pelanggan']); ?></td>
        </tr>
        <tr>
            <th>Telepon</th>
            <td><?php echo htmlspecialchars($data['telepon_pelanggan']); ?></td>
        </tr>
        <tr>
            <th>Tanggal Kunjungan</th>
            <td><?php echo htmlspecialchars($data['tanggal_kunjungan']); ?></td>
        </tr>
        <tr>
            <th>Teknisi</th>
            <td><?php echo htmlspecialchars($data['teknisi']); ?></td>
        </tr>
        <tr>
            <th>Deskripsi</th>
            <td><?php echo htmlspecialchars($data['deskripsi_kunjungan']); ?></td>
        </tr>
        <tr>
            <th>Status Kunjungan</th>
            <td><?php echo htmlspecialchars($data['status_kunjungan']); ?></td>
        </tr>
        <tr>
            <th>Gambar</th>
            <td>
                <?php if (!empty($data['gambar'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($data['gambar']); ?>" alt="Gambar Kunjungan" class="img-fluid">
                <?php else: ?>
                    Tidak ada gambar
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <a href="halaman_aktivitas.php" class="btn btn-secondary">Kembali</a>
</div>
</body>
</html>
