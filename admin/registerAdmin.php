<?php
// Pastikan hanya bisa melakukan registrasi ketika menggunakan POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password']; // Password yang dimasukkan oleh pengguna

    // Tentukan username dan password yang valid
    $valid_admins = [
        'admin_pengguna' => ['password' => 'adminpassword1', 'jenis_admin' => 'Admin Pengguna'],
        'admin_barang' => ['password' => 'adminpassword2', 'jenis_admin' => 'Admin Barang']
    ];

    // Cek apakah username valid
    if (isset($valid_admins[$username])) {
        // Verifikasi password
        if ($password === $valid_admins[$username]['password']) {
            // Meng-hash password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Koneksi ke database
            try {
                $pdo = new PDO('mysql:host=localhost;dbname=projek_ptc', 'root', '');
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Query untuk memasukkan data admin ke tabel adminbaru
                $query = "INSERT INTO adminbaru (username, password, jenis_admin, created_at) 
                          VALUES (:username, :password, :jenis_admin, NOW())";
                $stmt = $pdo->prepare($query);

                // Eksekusi query untuk menambahkan data
                $stmt->execute([
                    ':username' => $username,
                    ':password' => $hashed_password,
                    ':jenis_admin' => $valid_admins[$username]['jenis_admin']
                ]);

                echo "Admin berhasil ditambahkan!";
            } catch (PDOException $e) {
                echo "Koneksi gagal: " . $e->getMessage();
            }
        } else {
            echo "Password salah untuk username $username.";
        }
    } else {
        echo "Username tidak valid.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Admin</title>
    <link rel="stylesheet" href="../css/styleAdmin.css"> <!-- Hubungkan ke CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Registrasi Admin</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Daftar</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>
</html>
