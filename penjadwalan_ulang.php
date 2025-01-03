<?php
include "koneksi.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validasi input POST
    if (!isset($_POST['id'], $_POST['new_date'], $_POST['new_status'])) {
        echo "Data tidak lengkap.";
        exit;
    }
    
    // Mengambil data yang dikirim dari form
    $id = htmlspecialchars($_POST['id']);
    $new_date = htmlspecialchars($_POST['new_date']);
    $new_status = htmlspecialchars($_POST['new_status']); // Status baru dari form
    $diubah_oleh = 'Admin'; // Ubah sesuai nama user login

    // Validasi nilai status_kunjungan sesuai enum
    $allowed_status = ['Pending', 'Completed', 'Canceled'];
    if (!in_array($new_status, $allowed_status)) {
        echo "Status tidak valid.";
        exit;
    }

    // Mengambil id_pelanggan berdasarkan id aktivitas_kunjungan
    $sql_pelanggan = "SELECT id_pelanggan FROM aktivitas_kunjungan WHERE id = ?";
    if ($stmt_pelanggan = mysqli_prepare($kon, $sql_pelanggan)) {
        mysqli_stmt_bind_param($stmt_pelanggan, "i", $id);
        mysqli_stmt_execute($stmt_pelanggan);
        mysqli_stmt_bind_result($stmt_pelanggan, $id_pelanggan);
        mysqli_stmt_fetch($stmt_pelanggan);
        mysqli_stmt_close($stmt_pelanggan);

        // Memeriksa apakah id_pelanggan ada di tabel pelanggan
        $sql_check_pelanggan = "SELECT COUNT(*) FROM pelanggan WHERE id = ?";
        if ($stmt_check = mysqli_prepare($kon, $sql_check_pelanggan)) {
            mysqli_stmt_bind_param($stmt_check, "i", $id_pelanggan);
            mysqli_stmt_execute($stmt_check);
            mysqli_stmt_bind_result($stmt_check, $count);
            mysqli_stmt_fetch($stmt_check);
            mysqli_stmt_close($stmt_check);

            if ($count > 0) {
                // Update tanggal penjadwalan dan status kunjungan
                $sql = "UPDATE aktivitas_kunjungan SET tanggal_penjadwalan = ?, status_kunjungan = ? WHERE id = ?";
                if ($stmt = mysqli_prepare($kon, $sql)) {
                    mysqli_stmt_bind_param($stmt, "ssi", $new_date, $new_status, $id);
                    if (mysqli_stmt_execute($stmt)) {
                        mysqli_stmt_close($stmt);

                        // Tambahkan riwayat perubahan
                        $detail_perubahan = "Tanggal penjadwalan diubah menjadi '$new_date', status kunjungan diubah menjadi '$new_status'";
                        $sql_riwayat = "INSERT INTO riwayat_perubahan (id_pelanggan, aksi, detail_perubahan, diubah_oleh) 
                                        VALUES (?, 'Penjadwalan Ulang Kunjungan', ?, ?)";
                        if ($stmt_riwayat = mysqli_prepare($kon, $sql_riwayat)) {
                            mysqli_stmt_bind_param($stmt_riwayat, "sss", $id_pelanggan, $detail_perubahan, $diubah_oleh);
                            mysqli_stmt_execute($stmt_riwayat);
                            mysqli_stmt_close($stmt_riwayat);
                        }
                    } else {
                        echo "Gagal memperbarui data.";
                        exit;
                    }
                }
            } else {
                echo "ID Pelanggan tidak valid.";
                exit;
            }
        }
    }
    // Mengarahkan ke halaman tracking setelah selesai
    header("Location: tracking_kunjungan.php");
    exit;
}
?>
