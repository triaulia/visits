<?php
include("koneksi.php"); // Pastikan koneksi ke database sudah benar

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role']; // 'admin' atau 'user'

    // Validasi input
    if (empty($username) || empty($password) || empty($role)) {
        echo "Semua field harus diisi.";
        exit;
    }

    // Cek apakah username sudah ada
    $sql_check = "SELECT * FROM users WHERE username = ?";
    $stmt_check = $kon->prepare($sql_check);
    $stmt_check->bind_param("s", $username);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "Username sudah ada. Silakan pilih username lain.";
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Simpan pengguna baru ke database
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
}

$kon->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna - Visit Telkom</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('p.jpeg'); /* Ganti dengan URL gambar Anda */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .container {
            margin-top: 100px;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        }

        .btn-submit {
            background-color: #007bff;
            color: white;
        }

        .btn-submit:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2 class="text-center">Tambah Pengguna Baru</h2>

            <!-- Tampilkan pesan kesalahan jika ada -->
            <?php if (isset($error_message)): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control" id="username" placeholder="Masukkan username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password" required>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" class="form-control" id="role" required>
                        <option value="admin">Admin</option>
                        <option value="user">User </option>
                    </select>
                </div>
                <button type="submit" class="btn btn-submit btn-block">Tambah Pengguna</button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>