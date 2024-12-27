<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Selamat datang di Dasbor Admin</h1>

    <?php if ($role == 'admin1'): ?>
        <h2>Admin 1: Kelola Pengguna dan Permintaan Peminjaman</h2>
        <a href="kelolah_pengguna.php">Kelola Pengguna</a>
        <a href="Permintaan_Peminjaman.php">Kelola Permintaan Peminjaman</a>

    <?php elseif ($role == 'admin2'): ?>
        <h2>Admin 2: Kelola Pengguna dan Barang</h2>
        <a href="kelolah_pengguna.php">Kelola Pengguna</a>
        <a href="KelolahBarang.php">Kelola Barang</a>

    <?php else: ?>
        <p>Akses tidak sah</p>
    <?php endif; ?>

</body>
</html>
