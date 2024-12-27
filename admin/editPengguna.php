<?php
// Mulai sesi
session_start();

// Cek apakah admin sudah login dan memiliki role yang sesuai
if (!isset($_SESSION['username']) || $_SESSION['jenis_admin'] !== 'Admin Pengguna') {
    header('Location: loginAdmin.php'); // Arahkan ke halaman login jika tidak valid
    exit();
}

// Koneksi ke database
require('db_connection.php');

// Ambil ID pengguna dari URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mendapatkan data pengguna berdasarkan ID
    $sql = "SELECT * FROM admin WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
    } else {
        echo "Pengguna tidak ditemukan.";
        exit();
    }
} else {
    echo "ID pengguna tidak ditemukan.";
    exit();
}

// Proses form jika tombol submit ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $jenis_admin = $_POST['jenis_admin'];

    // Jika password baru diisi, hash password baru
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE admin SET username = ?, password = ?, jenis_admin = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $username, $hashed_password, $jenis_admin, $id);
    } else {
        $sql = "UPDATE admin SET username = ?, jenis_admin = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $username, $jenis_admin, $id);
    }

    if ($stmt->execute()) {
        $success_message = "Data pengguna berhasil diperbarui!";
    } else {
        $error_message = "Gagal memperbarui data pengguna. Silakan coba lagi.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-dark text-white py-3">
        <div class="container d-flex justify-content-between">
            <h1>Edit Pengguna</h1>
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

        <form method="POST" action="editPengguna.php?id=<?php echo $user['id']; ?>">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo $user['username']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password (Kosongkan jika tidak diubah)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="jenis_admin" class="form-label">Jenis Admin</label>
                <select class="form-select" id="jenis_admin" name="jenis_admin" required>
                    <option value="Admin Barang" <?php echo ($user['jenis_admin'] == 'Admin Barang') ? 'selected' : ''; ?>>Admin Barang</option>
                    <option value="Admin Pengguna" <?php echo ($user['jenis_admin'] == 'Admin Pengguna') ? 'selected' : ''; ?>>Admin Pengguna</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Pengguna</button>
        </form>
    </main>

    <footer class="bg-dark text-white py-3 text-center">
        <p>&copy; 2024 Sistem Peminjaman Barang Kampus</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
