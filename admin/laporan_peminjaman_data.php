<?php
include('../db_connection.php'); // File koneksi ke database

// Fungsi untuk mengambil data peminjaman berdasarkan bulan dan tahun
function getPeminjaman($table, $bulan, $tahun) {
    global $conn;
    $query = "SELECT *, ? AS sumber FROM $table WHERE MONTH(mulai_tanggal) = ? AND YEAR(mulai_tanggal) = ?";
    $stmt = $conn->prepare($query);
    $label = $table === 'peminjaman11' ? 'Kampus 1' : 'Kampus 2';
    $stmt->bind_param("sii", $label, $bulan, $tahun);
    $stmt->execute();
    return $stmt->get_result();
}

// Fungsi untuk mengekspor data ke dalam file CSV
function exportToCSV($data) {
    $filename = "laporan_peminjaman_" . date("Y-m-d") . ".csv";
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    $output = fopen('php://output', 'w');
    
    // Menulis header CSV
    $columns = ['ID', 'Nama Peminjam', 'Keperluan', 'Kode Barang', 'Ruang', 'Mulai Tanggal', 'Sampai Tanggal', 'Mulai Jam', 'Akhir Jam', 'Tanggal Pengembalian', 'Status', 'Sumber'];
    fputcsv($output, $columns);

    // Menulis data ke file CSV
    foreach ($data as $row) {
        fputcsv($output, $row);
    }

    fclose($output);
}

// Mengambil data peminjaman untuk kampus 1 dan kampus 2
if (isset($_GET['bulan']) && isset($_GET['tahun'])) {
    $bulan = $_GET['bulan'];
    $tahun = $_GET['tahun'];

    // Mengambil data dari kedua tabel
    $peminjaman1 = getPeminjaman('peminjaman11', $bulan, $tahun);
    $peminjaman2 = getPeminjaman('peminjaman22', $bulan, $tahun);

    // Menggabungkan hasil dari kedua kampus
    $allPeminjaman = [];
    while ($row = $peminjaman1->fetch_assoc()) {
        $allPeminjaman[] = $row;
    }
    while ($row = $peminjaman2->fetch_assoc()) {
        $allPeminjaman[] = $row;
    }

    // Mengekspor ke CSV
    exportToCSV($allPeminjaman);
}
?>
