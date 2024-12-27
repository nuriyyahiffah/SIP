<?php
session_start();
include('../db_connection.php');
if (!isset($_SESSION['jenis_admin']) || $_SESSION['jenis_admin'] != 'Admin Barang') {
    die("Akses ditolak.");
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt1 = $conn->prepare("DELETE FROM peminjaman1 WHERE id = ?");
    $stmt1->bind_param("i", $id);
    $stmt1->execute();
    $stmt1->close();

    $stmt2 = $conn->prepare("DELETE FROM peminjaman2 WHERE id = ?");
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $stmt2->close();

    header("Location: daftar_pengembalian.php");
    exit;
} else {
    echo "ID tidak valid.";
}
?>
