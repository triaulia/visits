<?php
include "koneksi.php"; // Koneksi ke database

// Menangkap kata kunci pencarian jika ada
$search_keyword = isset($_GET['search_keyword']) ? mysqli_real_escape_string($kon, $_GET['search_keyword']) : '';

// Menjalankan query untuk mengambil data dengan JOIN dan filter pencarian jika ada
$sql = "SELECT ak.*, p.nama_pelanggan FROM aktivitas_kunjungan ak
        JOIN pelanggan p ON ak.id_pelanggan = p.id";
if (!empty($search_keyword)) {
    $sql .= " WHERE p.nama_pelanggan LIKE '%$search_keyword%'";
}
$sql .= " ORDER BY ak.tanggal_kunjungan DESC";
$hasil = mysqli_query($kon, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <title>Tracking Status Kunjungan</title>
    <style>
        /* Styling untuk body */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        /* Navbar styling */
        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            color: #ffffff;
        }

        /* Container utama */
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 30px auto;
            max-width: 1200px;
        }

        /* Heading styling */
        h2 {
            color: #343a40;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Tabel styling */
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

        /* Form untuk update status */
        .form-control {
            width: auto;
            margin: 5px 0;
        }

        .btn-sm {
            font-size: 0.8rem;
            padding: 5px 10px;
        }

        /* Tombol styling */
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-weight: bold;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            font-weight: bold;
        }

        .btn-primary:hover, .btn-warning:hover {
            opacity: 0.9;
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
            .table {
                font-size: 0.9rem;
            }

            .container {
                padding: 15px;
            }

            h2 {
                font-size: 1.2rem;
            }

            .btn-sm {
                padding: 5px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="my-4 text-center">Penjadwalan Ulang Kunjungan</h2>

    <!-- Form pencarian -->
    <form class="form-inline" method="GET" action="">
        <input type="text" name="search_keyword" class="form-control" placeholder="Cari Nama Pelanggan" value="<?php echo htmlspecialchars($search_keyword); ?>">
        <button type="submit" class="btn btn-secondary">Cari</button>
    </form>

    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Tanggal Kunjungan</th>
                <th>Teknisi</th>
                <th>Status Kunjungan</th>
                <th>Ubah Status</th>
                <th>Tanggal Penjadwalan</th>
                <th>Jadwal Ulang</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($data = mysqli_fetch_assoc($hasil)) {
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($data["nama_pelanggan"]); ?></td>
                <td><?php echo htmlspecialchars($data["tanggal_kunjungan"]); ?></td>
                <td><?php echo htmlspecialchars($data["teknisi"]); ?></td>
                <td><?php echo htmlspecialchars($data["status_kunjungan"]); ?></td>
                <td>
                    <form action="update_status.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
                        <select name="status_kunjungan" class="form-control">
                            <option value="Pending" <?php if ($data["status_kunjungan"] == 'Pending') echo 'selected'; ?>>Pending</option>
                            <option value="Completed" <?php if ($data["status_kunjungan"] == 'Completed') echo 'selected'; ?>>Completed</option>
                            <option value="Canceled" <?php if ($data["status_kunjungan"] == 'Canceled') echo 'selected'; ?>>Canceled</option>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm mt-2">Update Status</button>
                    </form>
                </td>
                <td>
                    <?php
                    if (!empty($data["tanggal_penjadwalan"])) {
                        echo htmlspecialchars($data["tanggal_penjadwalan"]);
                    } else {
                        echo "Belum dijadwalkan";
                    }
                    ?>
                </td>
                <td>
                <form action="penjadwalan_ulang.php" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($data['id']); ?>"> <!-- ID kunjungan -->
                 <input type="hidden" name="new_status" value="<?php echo htmlspecialchars($data['status_kunjungan']); ?>"> <!-- Status lama -->
                 <input type="date" name="new_date" class="form-control" required> <!-- Tanggal baru -->
                 <button type="submit" class="btn btn-warning btn-sm mt-2">Jadwalkan</button>
                </form>
                </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
