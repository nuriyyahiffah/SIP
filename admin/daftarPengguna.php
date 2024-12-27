<?php
// Mulai sesi
session_start();

// Cek apakah admin sudah login dan memiliki role yang sesuai
if (!isset($_SESSION['username']) || $_SESSION['jenis_admin'] !== 'Admin Pengguna') {
    header('Location: loginAdmin.php'); // Arahkan ke halaman login jika tidak valid
    exit();
}

// Koneksi ke database
require('../db_connection.php'); // Sesuaikan dengan lokasi file koneksi

// Query untuk mendapatkan semua data pengguna
$sql = "
    SELECT u.id, u.nama_lengkap, u.nim, u.email, u.nomor_telepon
    FROM users u
    ORDER BY u.id DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Gaya umum */
        body {
            background-color:rgb(236, 31, 31);
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        header {
            background-color: rgb(0, 0, 0); /* Muted Blue */
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
            background-color: rgb(0, 0, 0);
            border: none;
        }

        header .btn-secondary:hover {
            background-color: #1C2E4A;
            color: white;
        }

        main {
            flex-grow: 1;
        }

        .table {
            background-color: rgb(0, 0, 0);
            color: rgb(0, 0, 0);
        }

        .table th {
            background-color: rgb(0, 0, 0);
            color: white;
        }

        .table tr:hover {
            background-color:rgb(0, 0, 0);
            color: white;
        }

        .btn {
            border: none;
            color: white;
        }

        .btn-warning {
            background-color: rgb(0, 0, 0);
        }

        .btn-warning:hover {
            background-color: #BDC4D4;
            color: rgb(0, 0, 0);
        }

        .btn-danger {
            background-color: rgba(15, 14, 14, 0.9);


        }

        .btn-danger:hover {
            background-color:rgb(131, 132, 133);
            color: white;
        }

        footer {
            background-color: rgb(0, 0, 0);
            color: white;
            text-align: center;
            padding: 15px 0;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <header>
        <div class="container d-flex justify-content-between">
            <h1>Daftar Pengguna</h1>
            <a href="adminPengguna.php" class="btn btn-secondary">Kembali</a>
        </div>
    </header>

    <main class="container my-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Lengkap</th>
                    <th>NIM</th>
                    <th>Email</th>
                    <th>Nomor Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nama_lengkap']; ?></td>
                        <td><?php echo $row['nim']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['nomor_telepon']; ?></td>
                        <td>
                            <a href="editPengguna.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                            <a href="hapusPengguna.php?id=<?php echo $row['id']; ?>" class="btn btn-danger">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; 2024 Sistem Peminjaman Barang Kampus</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
