<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = htmlspecialchars($_POST['id']);
    $status_kunjungan = htmlspecialchars($_POST['status_kunjungan']);
    $diubah_oleh = 'Admin'; // Bisa disesuaikan dengan sesi login

    // Update status kunjungan
    $sql_update = "UPDATE aktivitas_kunjungan SET status_kunjungan = ? WHERE id = ?";
    if ($stmt_update = mysqli_prepare($kon, $sql_update)) {
        mysqli_stmt_bind_param($stmt_update, "si", $status_kunjungan, $id);
        if (mysqli_stmt_execute($stmt_update)) {
            mysqli_stmt_close($stmt_update);

            // Tambahkan riwayat perubahan
            $detail_perubahan = "Status kunjungan diubah menjadi '$status_kunjungan'";
            $sql_riwayat = "INSERT INTO riwayat_perubahan (id_pelanggan, aksi, detail_perubahan, diubah_oleh) 
                            SELECT id_pelanggan, 'Update Status Kunjungan', ?, ? FROM aktivitas_kunjungan WHERE id = ?";
            if ($stmt_riwayat = mysqli_prepare($kon, $sql_riwayat)) {
                mysqli_stmt_bind_param($stmt_riwayat, "ssi", $detail_perubahan, $diubah_oleh, $id);
                mysqli_stmt_execute($stmt_riwayat);
                mysqli_stmt_close($stmt_riwayat);
            }
        } else {
            echo "Gagal memperbarui status.";
        }
    }
    // Redirect ke halaman utama setelah update
    header("Location: halaman_aktivitas.php");
    exit;
}
?>
