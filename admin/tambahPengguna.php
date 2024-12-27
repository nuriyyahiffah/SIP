<?php
// Mulai sesi
echo __DIR__;
session_start();

// Cek apakah admin sudah login dan memiliki role yang sesuai
if (!isset($_SESSION['username']) || $_SESSION['jenis_admin'] !== 'Admin Pengguna') {
    header('Location: loginAdmin.php'); // Arahkan ke halaman login jika tidak valid
    exit();
}

// Koneksi ke database
require('../db_connection.php');

// Proses form jika tombol submit ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $jenis_admin = $_POST['jenis_admin']; // Peran admin atau pengguna

    // Hash password sebelum disimpan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk memasukkan data pengguna baru
    $sql = "INSERT INTO admin (username, password, jenis_admin) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $hashed_password, $jenis_admin);

    if ($stmt->execute()) {
        $success_message = "Pengguna berhasil ditambahkan!";
    } else {
        $error_message = "Gagal menambahkan pengguna. Silakan coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-dark text-white py-3">
        <div class="container d-flex justify-content-between">
            <h1>Tambah Pengguna</h1>
            <a href="adminPengguna.php" class="btn btn-secondary">Kembali</a>
        </div>
    </header>

    <main class="container my-4">
        <?php
        if (isset($success_message)) {
            echo '<div class="alert alert-success">' . $success_message . '</div>';
        }
        if (isset($error_message)) {
            echo '<div class="alert alert-danger">' . $error_message . '</div>';
        }
        ?>

        <form method="POST" action="tambahPengguna.php">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="jenis_admin" class="form-label">Jenis Admin</label>
                <select class="form-select" id="jenis_admin" name="jenis_admin" required>
                    <option value="Admin Barang">Admin Barang</option>
                    <option value="Admin Pengguna">Admin Pengguna</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Pengguna</button>
        </form>
    </main>

    <footer class="bg-dark text-white py-3 text-center">
        <p>&copy; 2024 Sistem Peminjaman Barang Kampus</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
