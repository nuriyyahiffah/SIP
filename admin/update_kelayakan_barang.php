<?php
// Koneksi ke database
include '../db_connection.php';
// Include file fungsi evaluasi kelayakan
include 'fungsi_evaluasi.php';

// Ambil data barang dari tabel daftar_barang
$query = "SELECT * FROM daftar_barang";
$result = $conn->query($query);

// Cek apakah ada data
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $no = $row['no'];
        $kategori = $row['kategori'];
        $usia_barang = $row['usia_barang'];
        $jumlah_pemakaian = $row['jumlah_pemakaian'];
        $harga = $row['harga'];
        $total_barang = $row['total_barang'];

        // Evaluasi kelayakan
        $status_kelayakan = evaluasiKelayakanBarang($kategori, $usia_barang, $jumlah_pemakaian, $harga, $total_barang);

        // Update status kelayakan ke database
        $updateQuery = "UPDATE daftarbarang SET status_kelayakan = '$status_kelayakan' WHERE no = '$no'";

        if ($conn->query($updateQuery) === TRUE) {
            echo "Status kelayakan untuk barang $no telah diperbarui.<br>";
        } else {
            echo "Error: " . $conn->error . "<br>";
        }
    }
} else {
    echo "Tidak ada barang yang ditemukan.";
}

// Tutup koneksi
$conn->close();

?>
