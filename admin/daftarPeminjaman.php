<?php 
session_start();
include('../db_connection.php');
include('get_data_peminjaman2.php');  

define('ADMIN_PENGGUNA', 'Admin Pengguna');
define('ADMIN_BARANG', 'Admin Barang');

// Cek autentikasi admin
if (!isset($_SESSION['username']) || 
    ($_SESSION['jenis_admin'] !== ADMIN_PENGGUNA && $_SESSION['jenis_admin'] !== ADMIN_BARANG)) {
    header("Location: loginAdmin.php");
    exit;
}

// Fungsi untuk menyetujui peminjaman
if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'approve') {
    $id = intval($_GET['id']);
    
    // Pastikan peminjaman di kedua tabel diperbarui
    $stmt1 = $conn->prepare("UPDATE peminjaman11 SET status = 'approved' WHERE id = ?");
    $stmt1->bind_param("i", $id);
    $stmt1->execute();
    $stmt1->close();

    $stmt2 = $conn->prepare("UPDATE peminjaman22 SET status = 'approved' WHERE id = ?");
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $stmt2->close();

    // Menambahkan log aksi
    $stmt = $conn->prepare("INSERT INTO admin_logss (username, aksi, tanggal, status, description, created_at) 
                            VALUES (?, 'approve', NOW(), 'Disetujui', 'Permintaan peminjaman disetujui', NOW())");
    $stmt->bind_param("s", $_SESSION['username']);
    $stmt->execute();
    $stmt->close();

    // Redirect setelah aksi selesai
    header("Location: daftarPeminjaman.php");
    exit;
}

// Fungsi untuk menolak peminjaman
if (isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'reject') {
    $id = intval($_GET['id']);
    $barang_tidak_layak = false;

    // Cek kelayakan barang
    $stmt = $conn->prepare("SELECT status_kelayakan FROM daftarbarangg WHERE KODEBARANG = (SELECT kode_barang FROM peminjaman11 WHERE id = ? LIMIT 1)");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['status_kelayakan'] == 'Tidak Layak') {
            $barang_tidak_layak = true;
        }
    }
    $stmt->close();

    if ($barang_tidak_layak) {
        // Barang tidak layak, update status menjadi 'rejected' dan beri notifikasi
        $stmt1 = $conn->prepare("UPDATE peminjaman11 SET status = 'rejected' WHERE id = ?");
        $stmt1->bind_param("i", $id);
        $stmt1->execute();
        $stmt1->close();

        // Log aksi penolakan
        $stmt = $conn->prepare("INSERT INTO admin_logss (username, aksi, tanggal, status, description, created_at) 
                                VALUES (?, 'reject', NOW(), 'Ditolak', 'Barang tidak layak untuk dipinjam', NOW())");
        $stmt->bind_param("s", $_SESSION['username']);
        $stmt->execute();
        $stmt->close();
    } else {
        // Barang layak, lanjutkan penolakan
        $stmt1 = $conn->prepare("UPDATE peminjaman22 SET status = 'rejected' WHERE id = ?");
        $stmt1->bind_param("i", $id);
        $stmt1->execute();
        $stmt1->close();

        // Log aksi penolakan
        $stmt = $conn->prepare("INSERT INTO admin_logss (username, aksi, tanggal, status, description, created_at) 
                                VALUES (?, 'reject', NOW(), 'Ditolak', 'Permintaan peminjaman ditolak', NOW())");
        $stmt->bind_param("s", $_SESSION['username']);
        $stmt->execute();
        $stmt->close();
    }

    // Redirect setelah aksi selesai
    header("Location: daftarPeminjaman.php");
    exit;
}

// Ambil data peminjaman
$result = getPeminjamanData($conn);
if (!$result) {
    die("Query gagal: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Peminjaman</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(210, 210, 210);
            color: #1C2E4A;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #000000;
            padding: 15px;
            color: white;
            text-align: center;
        }
        .container {
            width: 90%;
            margin: 20px auto;
            max-height: 500px;
            overflow-y: auto;
        }
        .btn-kembali {
            display: inline-block;
            padding: 10px 15px;
            background-color: rgba(0, 0, 0, 0.9);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 10px;
            font-weight: bold;
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
            background-color: rgba(0, 0, 0, 0.9);
            color: white;
        }
        table tbody tr:hover {
            background-color: rgba(197, 197, 197, 0.54);
        }
        .icon-btn {
            font-size: 18px;
            cursor: pointer;
            margin: 0 5px;
            color: #1C2E4A;
            transition: color 0.2s, transform 0.2s;
        }
        .icon-btn:hover {
            color: #D9534F;
            transform: scale(1.1);
        }
        footer {
            background-color: #000000;
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
    <div class="header">
        <h2>Daftar Permintaan Peminjaman</h2>
    </div>
    <div class="container">
        <a href="adminPengguna.php" class="btn-kembali">Kembali</a>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Pengguna</th>
                    <th>Nama Barang</th>
                    <th>Kelayakan</th>
                    <th>Keperluan</th>
                    <th>Ruang</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $status_kelayakan = $row['status_kelayakan'];
                        $barang_tidak_layak = ($status_kelayakan == 'Tidak Layak');
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['nama_peminjam']) ?></td>
                            <td><?= htmlspecialchars($row['NAMABARANG'] ?? 'Barang Tidak Diketahui') ?></td>
                            <td><?= htmlspecialchars($row['status_kelayakan']) ?></td> 
                            <td><?= htmlspecialchars($row['keperluan']) ?></td>
                            <td><?= htmlspecialchars($row['ruang']) ?></td>
                            <td><?= htmlspecialchars($row['mulai_tanggal']) ?></td>
                            <td><?= htmlspecialchars($row['sampai_tanggal']) ?></td>
                            <td><?= htmlspecialchars($row['status']) ?></td>
                            <td>
                                <?php if ($barang_tidak_layak): ?>
                                    <span style="color: red;">Barang Tidak Layak</span>
                                    <a href="?action=reject&id=<?= $row['id'] ?>" class="icon-btn" title="rejected" onclick="return confirm('Barang ini tidak layak dipinjam, apakah Anda yakin ingin menolak permintaan ini?')">
                                        <i class="fas fa-times"></i>
                                    </a>
                                <?php else: ?>
                                    <a href="?action=approve&id=<?= $row['id'] ?>" class="icon-btn" title="approved">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="?action=reject&id=<?= $row['id'] ?>" class="icon-btn" title="rejected" onclick="return confirm('Apakah Anda yakin ingin menolak permintaan ini?')">
                                        <i class="fas fa-times"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo '<tr><td colspan="10">Tidak ada data peminjaman.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <footer>
        <p>&copy; 2024 Sistem Peminjaman Barang Kampus ITH</p>
    </footer>
</body>
</html>
