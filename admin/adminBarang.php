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

$query = "
    SELECT COUNT(*) AS total_disetujui
    FROM (
        SELECT id FROM peminjaman1 WHERE status = 'Disetujui'
        UNION ALL
        SELECT id FROM peminjaman2 WHERE status = 'Disetujui'
    ) AS peminjaman
";

$result = $conn->query($query);
$row = $result->fetch_assoc();
$totalDisetujui = $row['total_disetujui'];
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Pengelola Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color:rgb(255, 255, 255);
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: #000000;
            padding: 15px 0;
            position: sticky;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        header h1 {
            margin: 0;
            color: white;
        }

        header .btn-secondary {
            background-color: #000000;
            border: none;
        }

        main {
            flex-grow: 1;
        }

        .table {
            background-color: #FFFFFF;
            color: #000000;
        }

        .table th {
            background-color: #000000;
            color: white;
        }

        .table tr:hover {
            background-color:rgb(163, 163, 163);
            color: white;
        }

        footer {
            background-color: #000000;
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: auto;
        }

        .card {
            margin-bottom: 20px;
            background-color: #F1F4F8; /* Soft background color */
            border-radius: 10px; /* Rounded corners for a softer look */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */

        }

        .card i {
            font-size: 36px;
            margin-right: 15px;
            
        }

        .action-buttons {
            display: flex;
            justify-content: end;
            gap: 15px;
            margin-bottom: 20px;
        }

        .btn-custom {
            background-color:rgb(69, 70, 72);
            color: white;
        }

        .btn-custom:hover {
            background-color: #1C2E4A;
            color: white;
        }

        .text-dark {
            color: #1C2E4A;
        }

        .text-dark:hover {
            color: #1C2E4A;
        }

        .text-decoration-none {
            text-decoration: navajowhite;
        }
    </style>
</head>
<body>
    <header>
        <div class="container d-flex justify-content-between">
            <h1>Admin Barang</h1>
            <a href="logout.php" class="btn btn-secondary">Logout</a>
        </div>
    </header>

    <main class="container my-4">
        <div class="row">
            <!-- Card Statistik -->
            <div class="col-md-4">
                <a href="barangpinjam.php" class="text-decoration-none">
                    <div class="card p-3 shadow">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-box text-primary"></i>
                            <div>
                                <h5 class="text-dark">Total Barang Dipinjam</h5>
                                <h2 id="total-disetujui" class="text-dark"><?php echo $totalDisetujui; ?></h2>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="action-buttons">
            <a href="daftarBarang.php" class="btn btn-custom">
                <i class="fas fa-list"></i> Daftar Barang
            </a>
            <a href="tambahBarang.php" class="btn btn-custom">
                <i class="fas fa-plus"></i> Tambah Barang
            </a>
        </div>

        <h2></h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Nama Peminjam</th>
                    <th>Ruang</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="data-peminjaman">
                <!-- Data peminjaman akan diisi dengan AJAX -->
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; 2024 Sistem Peminjaman Barang Kampus | Logged in as: <?php echo $adminName; ?></p>
    </footer>

    <script>
function loadPeminjaman() {
    fetch('get_data_peminjaman.php')
    .then(response => response.json())
    .then(data => {
        let tableBody = document.getElementById('data-peminjaman');
        let totalDisetujui = 0;

        tableBody.innerHTML = '';
        if (data.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="8" class="text-center">Tidak ada data peminjaman</td></tr>';
        } else {
            data.forEach(peminjaman => {
                totalDisetujui++;
                let row = document.createElement('tr');
                row.innerHTML = `
                    <td>${peminjaman.kode_barang}</td>
                    <td>${peminjaman.NAMABARANG}</td>
                    <td>${peminjaman.nama_peminjam}</td>
                    <td>${peminjaman.ruang}</td>
                    <td>${peminjaman.mulai_tanggal}</td>
                    <td>${peminjaman.sampai_tanggal}</td>
                    <td>${peminjaman.status}</td>
                    <td>
                        <a href="editPeminjaman.php?id=${peminjaman.id}" class="icon-btn" title="Edit">
                            <i class="fas fa-pen-to-square"></i>
                        </a>
                        <a href="deletePeminjaman.php?id=${peminjaman.id}" class="icon-btn" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        document.getElementById('total-disetujui').textContent = totalDisetujui;
    })
    .catch(error => {
        console.error('Terjadi kesalahan:', error);
        let tableBody = document.getElementById('data-peminjaman');
        tableBody.innerHTML = '<tr><td colspan="8" class="text-center">Terjadi kesalahan, silakan coba lagi nanti</td></tr>';
    });
}


        document.addEventListener('DOMContentLoaded', loadPeminjaman);
    </script>
</body>
</html>
