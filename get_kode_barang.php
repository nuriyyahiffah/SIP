<?php
require_once 'db_connection.php';

if (isset($_GET['nama_barang'])) {
    $nama_barang = $_GET['nama_barang'];
    $query = "SELECT KODEBARANG, status_kelayakan AS status FROM daftarbarang WHERE NAMABARANG = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $nama_barang);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $kode_list = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $kode_list[] = $row;
    }

    echo json_encode($kode_list);
}
?>
