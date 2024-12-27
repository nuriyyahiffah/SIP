<?php
// koneksi database
$conn = new mysqli("localhost", "root", "", "projek_ptc");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mendapatkan kode_barang dari URL
$kode_barang = $_GET['kode_barang'];

// Cek apakah barang ada di database
$sql = "SELECT * FROM data_barang WHERE kode_barang = '$kode_barang'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($row) {
    // Mengurangi jumlah barang dan mengubah status menjadi Dipinjam
    if ($row['jumlah'] > 0) {
        $jumlah_baru = $row['jumlah'] - 1; // Mengurangi jumlah
        $status_barang = 'Dipinjam'; // Mengubah status

        // Update database
        $update_sql = "UPDATE data_barang SET jumlah = $jumlah_baru, status_barang = '$status_barang' WHERE kode_barang = '$kode_barang'";
        if ($conn->query($update_sql) === TRUE) {
            echo "Peminjaman berhasil!<br>";
            echo "<a href='daftarBarang.php'>Kembali ke Daftar Barang</a>"; // Link untuk kembali ke daftar barang
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Barang tidak tersedia untuk dipinjam.<br>";
        echo "<a href='daftarBarang.php'>Kembali ke Daftar Barang</a>";
    }
} else {
    echo "Barang tidak ditemukan.<br>";
    echo "<a href='daftarBarang.php'>Kembali ke Daftar Barang</a>";
}

// Menutup koneksi
$conn->close();
?>
