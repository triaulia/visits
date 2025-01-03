<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <title>Update Aktivitas Kunjungan</title>
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <span class="navbar-brand mb-0 h1">Telkom Indonesia</span>
    <a href="logout.php" class="btn btn-outline-light">Logout</a>
</nav>

<div class="container mt-4">
    <h4 class="text-center">Update Aktivitas Kunjungan</h4>

    <?php
    session_start();
    include "koneksi.php";

    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit;
    }

    $id = htmlspecialchars($_GET['id']);
    $query = "SELECT * FROM aktivitas_kunjungan WHERE id = $id";
    $result = mysqli_query($kon, $query);
    $data = mysqli_fetch_assoc($result);

    if (!$data) {
        echo "<div class='alert alert-danger'>Data tidak ditemukan.</div>";
        exit;
    }

    if (isset($_POST['update'])) {
        $tanggal_kunjungan = htmlspecialchars($_POST['tanggal_kunjungan']);
        $teknisi = htmlspecialchars($_POST['teknisi']);
        $deskripsi_kunjungan = htmlspecialchars($_POST['deskripsi_kunjungan']);
        $status_kunjungan = htmlspecialchars($_POST['status_kunjungan']);

        $query_update = "UPDATE aktivitas_kunjungan 
                         SET tanggal_kunjungan = '$tanggal_kunjungan', 
                             teknisi = '$teknisi', 
                             deskripsi_kunjungan = '$deskripsi_kunjungan', 
                             status_kunjungan = '$status_kunjungan' 
                         WHERE id = $id";

        if (mysqli_query($kon, $query_update)) {
            echo "<div class='alert alert-success'>Data berhasil diperbarui.</div>";
        } else {
            echo "<div class='alert alert-danger'>Gagal memperbarui data.</div>";
        }
    }
    ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="tanggal_kunjungan">Tanggal Kunjungan</label>
            <input type="date" name="tanggal_kunjungan" class="form-control" value="<?php echo htmlspecialchars($data['tanggal_kunjungan']); ?>" required>
        </div>
        <div class="form-group">
            <label for="teknisi">Teknisi</label>
            <input type="text" name="teknisi" class="form-control" value="<?php echo htmlspecialchars($data['teknisi']); ?>" required>
        </div>
        <div class="form-group">
            <label for="deskripsi_kunjungan">Deskripsi Kunjungan</label>
            <textarea name="deskripsi_kunjungan" class="form-control" required><?php echo htmlspecialchars($data['deskripsi_kunjungan']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="status_kunjungan">Status Kunjungan</label>
            <select name="status_kunjungan" class="form-control" required>
            <option value="Pending" <?php echo ($data['status_kunjungan'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
            <option value="Completed" <?php echo ($data['status_kunjungan'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
            <option value="Canceled" <?php echo ($data['status_kunjungan'] == 'Canceled') ? 'selected' : ''; ?>>Canceled</option>
            </select>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a href="halaman_aktivitas.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
