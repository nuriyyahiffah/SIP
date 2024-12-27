<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projek_ptc";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$tabel = isset($_GET['tabel']) ? $_GET['tabel'] : "";

$allowed_tables = ['peminjaman1', 'peminjaman2'];
if (!in_array($tabel, $allowed_tables) || $id <= 0) {
    die("ID atau tabel tidak valid.");
}

$sql = "DELETE FROM $tabel WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>alert('Data berhasil dihapus dari tabel $tabel!'); window.location.href='daftarPeminjaman.php';</script>";
    } else {
        echo "Gagal menghapus data: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Gagal mempersiapkan query: " . $conn->error;
}

$conn->close();
?>
