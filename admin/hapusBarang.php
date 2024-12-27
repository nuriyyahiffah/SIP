<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/SIPP/db_connection.php');

if (!isset($_SESSION['username']) || $_SESSION['jenis_admin'] != 'Admin Barang') {
    exit("Unauthorized access");
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM data_barang WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Data berhasil dihapus.";
        header("Location: adminbarang.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    exit("ID tidak diberikan.");
}
?>
