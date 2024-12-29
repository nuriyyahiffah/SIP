<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['jenis_admin'] !== 'Admin Barang') {
    header('Location: loginAdmin.php');
    exit();
}

$adminName = $_SESSION['username'] ?? 'Admin';

$conn = new mysqli('localhost', 'root', '', 'projek_ptc');
if ($conn->connect_error) {
    die('Koneksi database gagal: ' . $conn->connect_error);
}

$query = "
    SELECT 'peminjaman11' AS sumber, nama_peminjam, kode_barang, barang AS nama_barang 
    FROM peminjaman1 
    WHERE status = 'Disetujui'
    UNION ALL
    SELECT 'peminjaman22' AS sumber, nama_peminjam, kode_barang, barang AS nama_barang 
    FROM peminjaman2 
    WHERE status = 'approved'
    ORDER BY kode_barang, nama_peminjam
";

$result = $conn->query($query);
$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
$conn->close();
?>
