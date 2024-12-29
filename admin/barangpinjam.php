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

$data = [];

$query = "
    SELECT 'peminjaman11' AS id, nama_peminjam, kode_barang, barang AS nama_barang, created_at
    FROM peminjaman11 
    WHERE status = 'Disetujui'
    UNION ALL
    SELECT 'peminjaman22' AS id, nama_peminjam, kode_barang, barang AS nama_barang, created_at
    FROM peminjaman22 
    WHERE status = 'Disetujui'
    ORDER BY created_at DESC
";

$result = $conn->query($query);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;

        $kode_barang = $row['kode_barang'];
        $query_update = "UPDATE daftarbarangg SET TOTALBARANG = TOTALBARANG - 1 WHERE KODEBARANG = ?";
        $stmt = $conn->prepare($query_update);
        $stmt->bind_param("s", $KODEBARANG);
        $stmt->execute();
        $stmt->close();
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang yang Sedang Dipinjam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: rgb(250, 250, 250);
            color: #FFFFFF;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #1C1C1C;
            color: #FFFFFF;
            padding: 20px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            position: relative;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        .back-button {
            position: absolute;
            top: 50%;
            left: 20px;
            transform: translateY(-50%);
            background: none;
            border: 7px;
            color: #FFFFFF;
            font-size: 20px;
            cursor: pointer;
        }

        .back-button:hover {
            color: #888;
        }

        .container {
            margin: 20px auto;
            max-width: 90%;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color:rgb(236, 235, 235);
            color:rgb(0, 0, 0);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .table thead {
            background-color:rgb(0, 0, 0);
            color: #FFFFFF;
        }

        .table th, .table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solidrgb(150, 150, 150);
        }

        .table th {
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 1px;
        }

        .table tr:nth-child(even) {
            background-color:rgb(211, 208, 208);
        }

        .table tr:hover {
            background-color: rgb(121, 121, 121);
        }
        

        .table td {
            font-size: 16px;
        }

        footer {
            background-color:rgb(0, 0, 0);
            color: #FFFFFF;
            text-align: center;
            padding: 15px;
            position: fixed;
            bottom: 0;
            width: 100%;
            font-size: 14px;
        }

        footer a {
            color:rgb(255, 255, 255);
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <button class="back-button" onclick="history.back();">
            <i class="fas fa-arrow-left"></i> Kembali
        </button>
        <h1>Daftar Barang yang Sedang Dipinjam</h1>
    </header>
    <main class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Nama Peminjam</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data) && count($data) > 0): ?>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['kode_barang']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_barang']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_peminjam']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada barang yang sedang dipinjam</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
    <footer>
        <p>&copy; 2024 Sistem Peminjaman Barang Kampus | Logged in as: <?php echo htmlspecialchars($adminName); ?></p>
    </footer>
</body>
</html>
