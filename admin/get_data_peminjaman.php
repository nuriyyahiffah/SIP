<?php
include('../db_connection.php');

$query = "
    SELECT p.kode_barang, b.NAMABARANG, p.nama_peminjam, p.ruang, p.mulai_tanggal, p.sampai_tanggal, p.status
    FROM peminjaman11 p
    JOIN daftarbarangg b ON p.kode_barang = b.KODEBARANG
    UNION ALL
    SELECT p.kode_barang, b.NAMABARANG,  p.nama_peminjam, p.ruang, p.mulai_tanggal, p.sampai_tanggal, p.status
    FROM peminjaman22 p
    JOIN daftarbarangg b ON p.kode_barang = b.KODEBARANG
";

$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode(['error' => 'Query gagal: ' . mysqli_error($conn)]);
    exit();
}

$peminjamanData = [];
while ($row = mysqli_fetch_assoc($result)) {
    $peminjamanData[] = $row;
}

if (empty($peminjamanData)) {
    echo json_encode(['message' => 'Tidak ada data peminjaman.']);
    exit();
}

echo json_encode($peminjamanData);

mysqli_close($conn);
?>
