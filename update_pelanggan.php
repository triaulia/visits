<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <title>Update Data Pelanggan</title>
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <span class="navbar-brand mb-0 h1">Update Data Pelanggan</span>
</nav>

<div class="container">
    <br>
    <h4 class="text-center">Form Update Data Pelanggan</h4>

    <?php
        include "koneksi.php";

        session_start(); // Pastikan sesi aktif untuk mencatat siapa yang mengubah data

        // Fungsi sanitasi input
        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // Mendapatkan data pelanggan dari database berdasarkan ID
        if (isset($_GET["id"])) {
            $id = input($_GET["id"]);
            $sql = "SELECT * FROM pelanggan WHERE id=$id";
            $hasil = mysqli_query($kon, $sql);
            $data = mysqli_fetch_assoc($hasil);
        }

        // Menyimpan perubahan jika form disubmit
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = htmlspecialchars($_POST["id"]);
            $nama = input($_POST["nama_pelanggan"]);
            $alamat = input($_POST["alamat_pelanggan"]);
            $telepon = input($_POST["telepon_pelanggan"]);

            // Simpan data sebelum diupdate
            $query_old = "SELECT * FROM pelanggan WHERE id='$id'";
            $result_old = mysqli_query($kon, $query_old);
            $data_old = mysqli_fetch_array($result_old);

            // Query untuk update data
            $sql = "UPDATE pelanggan SET 
                    nama_pelanggan='$nama', 
                    alamat_pelanggan='$alamat', 
                    telepon_pelanggan='$telepon' 
                    WHERE id='$id'";
            $hasil = mysqli_query($kon, $sql);

            
        }
    ?>

    <!-- Form Update -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
        <div class="form-group">
            <label>Nama :</label>
            <input type="text" name="nama_pelanggan" class="form-control" value="" required />
        </div>
        <div class="form-group">
            <label>Alamat :</label>
            <input type="text" name="alamat_pelanggan" class="form-control" value="" required />
        </div>
        <div class="form-group">
            <label>Telepon :</label>
            <input type="text" name="telepon_pelanggan" class="form-control" value="" required />
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        <a href="halaman_pelanggan.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
</body>
</html>
