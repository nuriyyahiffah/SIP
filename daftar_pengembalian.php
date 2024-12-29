<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projek_ptc";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Cek apakah user adalah admin, jika tidak redirect
if (!isset($_SESSION['jenis_admin']) || $_SESSION['jenis_admin'] != 'Admin Barang') {
    echo "Akses ditolak. Hanya admin yang bisa mengakses halaman ini.";
    exit;
}

$sql = "SELECT * FROM peminjaman11 WHERE status = 'Dikembalikan' UNION SELECT * FROM peminjaman22 WHERE status = 'Dikembalikan' ORDER BY tanggal_pengembalian DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengembalian Barang</title>
    <link rel="stylesheet" href="style.css"> <!-- Tambahkan file CSS jika diperlukan -->
</head>
<body>
    <style>
        /* Reset default margin dan padding */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Desain umum halaman */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    color: #000000;
    padding: 20px;
}

/* Heading */
h1 {
    font-size: 24px;
    margin-bottom: 20px;
    text-align: center;
    color: #000000;
}

/* Tabel */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgb(0, 0, 0);
}

/* Header Tabel */
th {
    background-color: #000000;
    color: #fff;
    padding: 12px 15px;
    text-align: left;
    font-size: 16px;
}

/* Sel Tabel */
td {
    background-color: #fff;
    padding: 12px 15px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

/* Hover efek pada baris */
tr:hover {
    background-color: #f1f1f1;
}

/* Menambahkan gambar dengan ukuran maksimal */
td img {
    max-width: 100px;
    height: auto;
    border-radius: 5px;
}

/* Styling untuk kolom yang kosong jika foto tidak tersedia */
td {
    text-align: center;
}

/* Tabel Responsif */
@media (max-width: 768px) {
    table {
        font-size: 14px;
    }

    th, td {
        padding: 8px;
    }
}
    </style>
    <h1>Daftar Pengembalian Barang</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID Peminjaman</th>
                <th>Nama Peminjam</th>
                <th>Nama Barang</th>
                <th>Tanggal Pengembalian</th>
                <th>Foto Pengembalian</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['nama_peminjam'] . "</td>";
                    echo "<td>" . $row['barang'] . "</td>";
                    echo "<td>" . $row['tanggal_pengembalian'] . "</td>";

                    // Jika foto pengembalian ada, tampilkan gambar
                    if ($row['foto_pengembalian']) {
                        echo "<td><img src='" . $row['foto_pengembalian'] . "' alt='Foto Pengembalian'></td>";
                    } else {
                        echo "<td>Foto tidak tersedia</td>";
                    }
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Tidak ada barang yang dikembalikan.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
