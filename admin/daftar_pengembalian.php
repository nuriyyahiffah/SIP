<?php
session_start();

// Cek apakah session 'jenis_admin' sudah diset
if (!isset($_SESSION['jenis_admin'])) {
    echo "Sesi jenis_admin tidak diatur. Harap login ulang.";
    exit;
}

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projek_ptc";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Cek apakah jenis_admin adalah 'Admin Pengguna'
if ($_SESSION['jenis_admin'] != 'Admin Pengguna') {
    echo "Akses ditolak. Hanya admin yang bisa mengakses halaman ini.";
    exit;
}

// Query untuk mengambil data pengembalian barang
$allowed_tables = ['peminjaman11', 'peminjaman22'];
$query_parts = [];
foreach ($allowed_tables as $table) {
    $query_parts[] = "(SELECT id, nama_peminjam, barang, tanggal_pengembalian, foto_pengembalian FROM $table WHERE status = 'Dikembalikan')";
}
$sql = implode(" UNION ", $query_parts) . " ORDER BY tanggal_pengembalian DESC";

// Eksekusi query
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengembalian Barang</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #000000;
            padding: 20px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            color: #000000;
        }

        .btn-kembali {
            color: #333;
            font-size: 20px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
        }

        .btn-kembali:hover {
            color: #007bff;
            transform: scale(1.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgb(54, 54, 54);
        }

        th {
            background-color: #333;
            color:rgb(255, 255, 255);
            padding: 12px 15px;
            text-align: left;
            font-size: 16px;
        }

        td {
            background-color: #fff;
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        td img {
            max-width: 100px;
            height: auto;
            border-radius: 5px;
        }

        .btn-hapus {
            color: navy;
            font-size: 18px;
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.2s, color 0.2s;
        }

        .btn-hapus:hover {
            color: red;
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            table {
                font-size: 14px;
            }

            th, td {
                padding: 8px;
            }
        }
    </style>

    <!-- Back Button -->
    <a href="adminPengguna.php" class="btn-kembali"><i class="fas fa-arrow-left"></i> Kembali</a>

    <h1>Daftar Pengembalian Barang</h1>
    <table>
        <thead>
            <tr>
                <th>ID Peminjaman</th>
                <th>Nama Peminjam</th>
                <th>Nama Barang</th>
                <th>Tanggal Pengembalian</th>
                <th>Foto Pengembalian</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Menampilkan data hasil query
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_peminjam']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['barang']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tanggal_pengembalian']) . "</td>";

                    $foto_path = '../'.htmlspecialchars($row['foto_pengembalian']);
                    if (!empty($foto_path) && file_exists($foto_path)) {
                        echo "<td><img src='$foto_path' alt='Foto Pengembalian'></td>";
                    } else {
                        echo "<td>Foto tidak tersedia</td>";
                    }

                    echo "<td>
                            <a href='hapusPengembalian.php?id=" . $row['id'] . "' class='btn-hapus' onclick=\"return confirm('Apakah Anda yakin ingin menghapus data ini?')\">
                                <i class='fas fa-trash'></i>
                            </a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Tidak ada barang yang dikembalikan.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
