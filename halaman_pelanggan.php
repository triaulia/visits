<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <title>Data Pelanggan</title>
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
    <h4 class="text-center">Daftar Pelanggan</h4>

    <?php
    include "koneksi.php";
    session_start(); // Mulai sesi pengguna

    // Cek apakah pengguna sudah login
    if (!isset($_SESSION['username'])) {
        header("Location: login.php"); // Redirect ke halaman login jika sesi tidak ditemukan
        exit;
    }

    // Menghapus data jika ada parameter id pada URL
    if (isset($_GET['id'])) {
        $id = htmlspecialchars($_GET["id"]);
    
        // Simpan data sebelum dihapus
        $query_old = "SELECT * FROM pelanggan WHERE id='$id'";
        $result_old = mysqli_query($kon, $query_old);
    
        if ($result_old && mysqli_num_rows($result_old) > 0) {
            $data_old = mysqli_fetch_array($result_old);
    
            // Hapus data pelanggan
            $sql = "DELETE FROM pelanggan WHERE id='$id'";
            $hasil = mysqli_query($kon, $sql);
        } else {
            echo "<div class='alert alert-warning'>Data pelanggan tidak ditemukan atau sudah dihapus.</div>";
        }
    }
    
    // Filter pencarian
    $keyword = isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '';
    $sql = "SELECT * FROM pelanggan";
    if ($keyword) {
        $sql .= " WHERE nama_pelanggan LIKE '%$keyword%' OR alamat_pelanggan LIKE '%$keyword%' OR telepon_pelanggan LIKE '%$keyword%'";
    }
    $sql .= " ORDER BY id";
    $hasil = mysqli_query($kon, $sql);
    ?>

    <!-- Form Pencarian -->
<form method="get" action="" class="form-inline">
    <input type="text" name="keyword" placeholder="Cari..." value="<?php echo $keyword; ?>" class="form-control" style="width: 300px;">
    <button type="submit" class="btn btn-primary ml-2">Cari</button>
    <a href="halaman_pelanggan.php" class="btn btn-secondary ml-2">Reset</a>
</form>
    <!-- Tabel Hasil Pencarian -->
    <table class="my-3 table table-bordered">
        <thead class="table-primary">
            <tr>
                <th>No</th>
                <th>ID Pelanggan</th>
                <th>Nama </th>
                <th>Alamat </th>
                <th>Telepon </th>
                <th colspan="2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 0;
            while ($data = mysqli_fetch_array($hasil)) {
                $no++;
            ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo htmlspecialchars($data["id"]); ?></td> <!-- Menampilkan ID -->
                    <td><?php echo htmlspecialchars($data["nama_pelanggan"]); ?></td>
                    <td><?php echo htmlspecialchars($data["alamat_pelanggan"]); ?></td>
                    <td><?php echo htmlspecialchars($data["telepon_pelanggan"]); ?></td>
                    <td>
                        <a href="update_pelanggan.php?id=<?php echo htmlspecialchars($data['id']); ?>" class="btn btn-warning">Update</a>
                        <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=<?php echo htmlspecialchars($data['id']); ?>" class="btn btn-danger" onclick="return confirm('Anda yakin ingin menghapus data ini?')">Delete</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <a href="tambah_pelanggan.php" class="btn btn-primary">Tambah Data</a>
</div>
</body>
</html>
