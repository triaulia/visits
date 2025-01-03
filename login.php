<?php
session_start();
if (isset($_GET['error'])) {
    echo "<p style='color:red;'>Login gagal. Cek username dan password Anda.</p>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Visit Telkom</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        body {
            background-image: url('p.jpeg'); /* Ganti dengan URL gambar Anda */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .logo {
            width: 130px; /* Sesuaikan ukuran logo */
            display: block; /* Agar logo berada di tengah */
            margin: 0 auto 10px; /* Margin atas dan bawah */
        }
        
        .kotak_login {
            width: 300px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            margin: 100px auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .form_login {
            width: 97%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .tombol_login {
            width: 95%;
            padding: 5px;
            margin:10px;
            background:rgb(214, 18, 18);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .tulisan_login {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
            font-weight: bold; /* Membuat tulisan menjadi bold */
        }

        label {
            color: yellow; /* Mengubah warna label menjadi kuning */
            font-weight: bold; /* Membuat label menjadi bold */
            display: block; /* Agar label berada di baris baru */
            text-align: center; /* Menempatkan label di tengah */
            margin-bottom: 5px; /* Memberikan jarak antara label dan input */
        }

        input[type="text"], input[type="password"] {
            color: yellow; /* Mengubah warna teks input menjadi kuning */
            text-align: left; /* Menempatkan teks input di tengah */
        }
    </style>
</head>
<body>
    <div class="kotak_login">

         <!-- Tambahkan gambar logo perusahaan di sini -->
         <img src="logo.png" alt="Logo Perusahaan" class="logo">

        <p class="tulisan_login">SELAMAT DATANG DI VISIT TELKOM</p>
        <p class="tulisan_login">Silahkan Login terlebih dahulu</p>

        <!-- Tampilkan pesan kesalahan jika login gagal -->
        <?php if (isset($_GET['error'])): ?>
            <p style="color: red;">Username atau password salah</p>
        <?php endif; ?>
        
        <!-- Form start -->
        <form action="ceklogin.php" method="post" role="form">
            <label>Username</label>
            <input type="text" name="username" class="form_login" placeholder="Username" autocomplete="off" required>

            <label>Password</label>
            <input type="password" name="password" class="form_login" placeholder="Password" autocomplete="off" required>

            <input type="submit" class="tombol_login" value="Login">
        </form> <!-- Form end -->
    </div>
</body>
</html>