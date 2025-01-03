<?php
session_start();
include("koneksi.php"); // Pastikan koneksi ke database sudah benar

// Jika pengguna sudah login, arahkan ke dashboard
if (isset($_SESSION['username'])) {
    if ($_SESSION['role'] == 'admin') {
        header("location: dashboard.php");
    } else {
        header("location: dashboard_teknisi.php");
    }
    exit;
}

$username = "";
$password = "";
$err = "";

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi input kosong
    if ($username == '' || $password == '') {
        $err .= "<li>Silakan masukkan username dan password</li>";
    }

    if (empty($err)) {
        // Query untuk mendapatkan data pengguna
        $sql1 = "SELECT * FROM users WHERE username = ?";
        $stmt = $kon->prepare($sql1);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $r1 = $result->fetch_assoc();

            // Periksa password
            if (password_verify($password, $r1['password'])) {
                // Simpan session
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $r1['role']; // Menyimpan peran pengguna (admin/user)

                // Arahkan ke dashboard sesuai peran
                if ($r1['role'] == 'admin') {
                    header("location: dashboard.php"); // Dashboard admin
                } else {
                    header("location: dashboard_teknisi.php"); // Dashboard pengguna
                }
                exit();
            } else {
                $err .= "<li>Password salah</li>";
            }
        } else {
            $err .= "<li>Akun tidak ditemukan</li>";
        }
    }
}

// Jika ada error, redirect kembali ke halaman login dengan pesan error
if (!empty($err)) {
    header("Location: login.php?error=1");
    exit;
}
?>