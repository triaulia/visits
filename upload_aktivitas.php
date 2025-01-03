<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "visit_teknisi");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Tangkap data dari form
$nama_pelanggan = $_POST['nama_pelanggan'];
$alamat_pelanggan = $_POST['alamat_pelanggan'];
$telepon_pelanggan = $_POST['telepon_pelanggan'];
$tanggal_kunjungan = $_POST['tanggal_kunjungan'];
$teknisi = $_POST['teknisi'];
$deskripsi_kunjungan = $_POST['deskripsi_kunjungan'];
$status_kunjungan = $_POST['status_kunjungan'];

// Proses upload gambar
$gambar = $_FILES['gambar'];
$target_dir = "uploads/";
$target_file = $target_dir . basename($gambar["name"]);

if (move_uploaded_file($gambar["tmp_name"], $target_file)) {
    // Simpan pelanggan baru ke tabel `pelanggan`
    $stmt = $conn->prepare("INSERT INTO pelanggan (nama_pelanggan, alamat_pelanggan, telepon_pelanggan) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama_pelanggan, $alamat_pelanggan, $telepon_pelanggan);
    $stmt->execute();
    $id_pelanggan = $stmt->insert_id; // Dapatkan id_pelanggan yang baru ditambahkan
    $stmt->close();

    // Simpan data ke tabel `aktivitas_kunjungan`
    $stmt = $conn->prepare("INSERT INTO aktivitas_kunjungan (id_pelanggan, tanggal_kunjungan, teknisi, deskripsi_kunjungan, status_kunjungan, gambar) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $id_pelanggan, $tanggal_kunjungan, $teknisi, $deskripsi_kunjungan, $status_kunjungan, $target_file);
    $stmt->execute();
    $stmt->close();

    echo "Data berhasil disimpan.";
} else {
    echo "Gagal mengunggah gambar.";
}

$conn->close();
?>
