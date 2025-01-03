<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <title> Data Pelanggan</title>
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
            max-width: 600px;
        }

        /* Heading styling */
        h4 {
            color: #343a40;
            font-weight: bold;
            text-transform: uppercase;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Tombol styling */
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            font-weight: bold;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            font-weight: bold;
        }

        .btn:hover {
            opacity: 0.9;
        }

        /* Form styling */
        .form-group label {
            font-weight: bold;
        }

        .form-control {
            border-radius: 5px;
        }

        /* Responsivitas */
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
  

<nav class="navbar navbar-dark bg-dark">
    <span class="navbar-brand mb-0 h1"> Tambah Data Pelanggan</span>
</nav>
 
<div class="container">
    <?php
        include "koneksi.php";

        function input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nama = input($_POST["nama_pelanggan"]);
            $alamat = input($_POST["alamat_pelanggan"]);
            $telepon = input($_POST["telepon_pelanggan"]);

            $sql = "INSERT INTO pelanggan (nama_pelanggan, alamat_pelanggan, telepon_pelanggan) 
                    VALUES ( '$nama', '$alamat', '$telepon')";
            $hasil=mysqli_query($kon,$sql);
            
            if   ($hasil) {
                header ("Location: halaman_pelanggan.php");
              }
              else {
                echo"<div class='alert alert-danger'> data gagal di simpan</div>";

              }

            }
    ?>


    <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        <div class="form-group">
            <label>Nama </label>
            <input type="text" name="nama_pelanggan" class="form-control" placeholder="Masukkan Nama Pelanggan" required />
        </div>
        <div class="form-group">
            <label>Alamat </label>
            <input type="text" name="alamat_pelanggan" class="form-control" placeholder="Masukkan Alamat Pelanggan" required />
        </div>
        <div class="form-group">
            <label>Telepon </label>
            <input type="text" name="telepon_pelanggan" class="form-control" placeholder="Masukkan Telepon Pelanggan" required />
        </div>
        <button type="submit" name="submit" class ="btn btn-success"> Submit</button>
        <a href="dashboard.php" class="btn btn-secondary">Batal</a>
    </form>
 

</div>
</body>
</html>
