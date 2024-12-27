<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['jenis_admin'] !== 'Admin Barang') {
    header('Location: loginAdmin.php');
    exit();
}

include ('../db_connection.php');

$query = "SELECT NO, KODEBARANG, NAMABARANG, USIABARANG, TAHUNMASUK, JUMLAHPEMAKAIAN, HARGA, TOTALBARANG, KATEGORI, status_kelayakan FROM daftarbarang";
$result = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
       body {
    font-family: Arial, sans-serif;
    background-color:rgb(255, 255, 255);
    color: rgba(15, 14, 14, 0.9);
    margin: 0;
    padding: 0;
}

.header {
    background-color: rgba(15, 14, 14, 0.9);
    padding: 10px 20px;
    color: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.header h1 {
    font-size: 24px;
    margin: 0;
}

.btn-kembali {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 8px;
    background-color: transparent;
    border: none;
    color: white;
    text-decoration: none;
    font-size: 18px;
}

.btn-kembali:hover {
    color: #D0D9E3;
}

.btn-kembali i {
    margin-right: 5px;
}

.container {
    width: 90%;
    margin: 20px auto;
    max-height: 500px; 
    overflow-y: auto; 
}

table {
    width: 100%;
    border-collapse: collapse;
    background-color: #F4F9FB;
    margin: 20px 0;
    border-radius: 8px;
    overflow: hidden;
}

table th, table td {
    border: 1px solid #C1C8D3;
    padding: 12px;
    text-align: center;
}

table th {
    background-color: rgba(15, 14, 14, 0.9);
    color:rgb(0, 0, 0);  
    font-weight: bold; 
}

table tbody tr:hover {
    background-color: #D0D9E3;
}

footer {
    background-color: rgba(15, 14, 14, 0.9);
    color: white;
    text-align: center;
    padding: 10px;
    position: fixed;
    bottom: 0;
    width: 100%;
}

    </style>
</head>
<body>
    <header class="header">
        <a href="adminBarang.php" class="btn-kembali">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <h1>Daftar Barang</h1>
    </header>
    <main class="container">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Usia Barang</th>
                    <th>Tahun Masuk</th>
                    <th>Jumlah Pakai</th>
                    <th>Harga</th>
                    <th>Kategori</th>
                    <th>Total Barang</th>
                    <th>Status Kelayakan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                        
                                <td>{$row['KODEBARANG']}</td>
                                <td>{$row['NAMABARANG']}</td>
                                <td>{$row['USIABARANG']}</td>
                                <td>{$row['TAHUNMASUK']}</td>
                                <td>{$row['JUMLAHPEMAKAIAN']}</td>
                                <td>{$row['HARGA']}</td>
                                <td>{$row['KATEGORI']}</td>
                                <td>{$row['TOTALBARANG']}</td>
                                <td>{$row['status_kelayakan']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>Tidak ada data barang</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
    <footer>
        <p>&copy; 2024 Sistem Peminjaman Barang Kampus</p>
    </footer>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
