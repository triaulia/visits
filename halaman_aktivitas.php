<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <title>Aktivitas Kunjungan</title>
    <style>
        /* Mengatur font dasar dan warna latar belakang */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        /* Desain Navbar */
        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }

        /* Kontainer utama */
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 30px auto;
            max-width: 1200px;
        }

        /* Heading */
        h4 {
            color: #343a40;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        /* Tabel */
        .table {
            margin-top: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }

        .table thead th {
            background-color: #007bff;
            color: #ffffff;
            text-align: center;
        }

        .table tbody td {
            vertical-align: middle;
            text-align: center;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Tombol */
        .btn {
            margin: 5px;
            border-radius: 5px;
            font-weight: bold;
        }

        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
            color: #fff;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #fff;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }

        /* Form pencarian */
        .form-inline {
            justify-content: left;
            margin-bottom: 20px;
        }

        .form-inline .form-control {
            width: auto;
            margin-right: 10px;
        }

        .form-inline .btn-secondary {
            margin-left: 10px;
        }

        /* Responsivitas */
        @media (max-width: 768px) {
            .form-inline {
                flex-direction: column;
            }

            .form-inline .form-control,
            .form-inline .btn {
                margin-bottom: 10px;
                width: 100%;
            }

            .table {
                font-size: 0.9rem;
            }
        }

        .alert {
            margin-top: 10px;
        }

        /* Link untuk gambar */
        a.btn-info {
            font-size: 0.9rem;
            padding: 5px 10px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <span class="navbar-brand mb-0 h1">Telkom Indonesia</span>
    <a href="logout.php" class="btn btn-outline-light">Logout</a>
</nav>

<div class="container">
    <br>
    <h4 class="text-center">Aktivitas Kunjungan</h4>

    <?php
    session_start();
    include "koneksi.php";

    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit;
    }

    // Menangani pencarian berdasarkan kata kunci
    $keyword = isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '';
    $sql = "SELECT ak.*, p.nama_pelanggan, p.alamat_pelanggan, p.telepon_pelanggan 
            FROM aktivitas_kunjungan ak 
            JOIN pelanggan p ON ak.id_pelanggan = p.id";
    if ($keyword) {
        $sql .= " WHERE p.nama_pelanggan LIKE '%$keyword%' 
                  OR ak.teknisi LIKE '%$keyword%' 
                  OR ak.status_kunjungan LIKE '%$keyword%'";
    }
    $hasil = mysqli_query($kon, $sql);

    // Proses penghapusan data
    if (isset($_GET['id'])) {
        $id = htmlspecialchars($_GET["id"]);
        $delete_query = "DELETE FROM aktivitas_kunjungan WHERE id = $id";
        if (mysqli_query($kon, $delete_query)) {
            echo "<div class='alert alert-success'>Data berhasil dihapus.</div>";
        } else {
            echo "<div class='alert alert-danger'>Gagal menghapus data.</div>";
        }
    }

    // Proses update status kunjungan
    if (isset($_POST['update_status'])) {
        $id = $_POST['id'];
        $status_kunjungan = $_POST['status_kunjungan'];
        $update_query = "UPDATE aktivitas_kunjungan SET status_kunjungan = '$status_kunjungan' WHERE id = $id";
        if (mysqli_query($kon, $update_query)) {
            echo "<div class='alert alert-success'>Status berhasil diupdate.</div>";
        } else {
            echo "<div class='alert alert-danger'>Gagal mengupdate status.</div>";
        }
    }
    ?>

    <form method="GET" action="" class="form-inline mb-3">
        <input type="text" name="keyword" class="form-control mr-sm-2" placeholder="Cari data..." value="<?php echo $keyword; ?>">
        <button type="submit" class="btn btn-primary">Cari</button>
        <a href="halaman_aktivitas.php" class="btn btn-secondary ml-2">Reset</a>
    </form>

    <table class="table table-bordered">
        <thead class="table-primary">
            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Telepon</th>
                <th>Tanggal</th>
                <th>Teknisi</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        while ($data = mysqli_fetch_assoc($hasil)) {
        ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($data["id"]); ?></td>
                <td><?php echo htmlspecialchars($data["nama_pelanggan"]); ?></td>
                <td><?php echo htmlspecialchars($data["alamat_pelanggan"]); ?></td>
                <td><?php echo htmlspecialchars($data["telepon_pelanggan"]); ?></td>
                <td><?php echo htmlspecialchars($data["tanggal_kunjungan"]); ?></td>
                <td><?php echo htmlspecialchars($data["teknisi"]); ?></td>
                <td><?php echo htmlspecialchars($data["deskripsi_kunjungan"]); ?></td>
                <td>
                    <!-- Dropdown untuk memilih status -->
                    <form method="POST" action="" class="d-inline">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($data['id']); ?>">
                        <select name="status_kunjungan" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="Pending" <?php echo ($data['status_kunjungan'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                            <option value="Completed" <?php echo ($data['status_kunjungan'] == 'Completed') ? 'selected' : ''; ?>>Completed</option>
                            <option value="Canceled" <?php echo ($data['status_kunjungan'] == 'Canceled') ? 'selected' : ''; ?>>Canceled</option>
                        </select>
                    </form>
                </td>
                <td>
                    <?php if ($data["gambar"]): ?>
                        <a href="uploads/<?php echo htmlspecialchars($data["gambar"]); ?>" target="_blank" class="btn btn-info">Lihat</a>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="detail_aktivitas.php?id=<?php echo htmlspecialchars($data['id']); ?>" class="btn btn-info">Detail</a>
                    <a href="update_aktivitas.php?id=<?php echo htmlspecialchars($data['id']); ?>" class="btn btn-warning">Update</a>
                    <a href="?id=<?php echo htmlspecialchars($data['id']); ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>

    <a href="tambah_aktivitas.php" class="btn btn-primary">Tambah Data</a>
</div>
</body>
</html>
