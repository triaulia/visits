<?php
include("koneksi.php"); // Pastikan koneksi ke database sudah benar

$username = 'admin'; // Ganti dengan input dari form
$password = 'telkom2024'; // Password asli
$hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash password
$role = 'admin'; // Ganti dengan input dari form

// Cek apakah username sudah ada
$sql_check = "SELECT * FROM users WHERE username = ?";
$stmt_check = $kon->prepare($sql_check);
$stmt_check->bind_param("s", $username);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo "Username sudah ada. Silakan pilih username lain.";
} else {
    // Simpan $hashed_password ke database
    $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = $kon->prepare($sql);
    $stmt->bind_param("sss", $username, $hashed_password, $role);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Pengguna berhasil ditambahkan.";
    } else {
        echo "Gagal menambahkan pengguna.";
    }

    $stmt->close();
}

$stmt_check->close();
$kon->close();
?>