<?php
include 'laporan_peminjaman_data.php';

// Ambil bulan dan tahun dari parameter URL atau default ke bulan dan tahun saat ini
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

// Ambil data dari kedua tabel
$dataKampus1 = getPeminjaman('peminjaman11', $bulan, $tahun);
$dataKampus2 = getPeminjaman('peminjaman22', $bulan, $tahun);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman</title>
    <link rel="stylesheet" href="laporan_peminjaman.css">
    </head>
<body>
    <h1>Laporan Peminjaman Barang</h1>

    <form method="GET" action="laporan_peminjaman.php">
        <label for="bulan">Bulan:</label>
        <select name="bulan" id="bulan">
            <?php
            for ($i = 1; $i <= 12; $i++) {
                $selected = $i == $bulan ? 'selected' : '';
                echo "<option value='$i' $selected>" . date('F', mktime(0, 0, 0, $i, 10)) . "</option>";
            }
            ?>
        </select>
        <label for="tahun">Tahun:</label>
        <select name="tahun" id="tahun">
            <?php
            for ($i = 2020; $i <= date('Y'); $i++) {
                $selected = $i == $tahun ? 'selected' : '';
                echo "<option value='$i' $selected>$i</option>";
            }
            ?>
        </select>
        <button type="submit">Tampilkan</button>
    </form>

    <!-- Tabel untuk Kampus 1 -->
    <h2>Data Peminjaman Kampus 1</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Peminjam</th>
                <th>Barang</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $dataKampus1->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['nama_peminjam'] ?></td>
                <td><?= $row['barang'] ?></td>
                <td><?= $row['mulai_tanggal'] ?></td>
                <td><?= $row['sampai_tanggal'] ?></td>
                <td><?= $row['status'] ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Tabel untuk Kampus 2 -->
    <h2>Data Peminjaman Kampus 2</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Peminjam</th>
                <th>Barang</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $dataKampus2->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['nama_peminjam'] ?></td>
                <td><?= $row['barang'] ?></td>
                <td><?= $row['mulai_tanggal'] ?></td>
                <td><?= $row['sampai_tanggal'] ?></td>
                <td><?= $row['status'] ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
