<?php
require_once 'koneksi.php';

if (isset($_GET['id'])) {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

    $stmt = $conn->prepare("UPDATE peminjaman1 SET status = 'Diterima' WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        header("Location: daftar_peminjaman.php");
        exit();
    } else {
        echo "Gagal memperbarui status.";
    }
}
?>
