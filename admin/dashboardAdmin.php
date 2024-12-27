<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'projek_ptc');

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data untuk statistik
$totalBarang = $conn->query("SELECT COUNT(*) AS total FROM data_barang")->fetch_assoc()['total'];
$totalPeminjaman = $conn->query("SELECT COUNT(*) AS total FROM peminjaman1")->fetch_assoc()['total'];
$totalPengguna = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #E4D8C8;
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color:rgb(0, 0, 0);
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background-color: #FFFFFF;
        }
        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color:rgb(255, 255, 255);
        }
        .btn-orange {
            background-color:rgb(0, 0, 0);
            color: white;
        }
        .btn-orange:hover {
            background-color:rgb(0, 0, 0);
            color: white;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#dashboard">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="riwayat_peminjaman.php">Riwayat Peminjaman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kelola_peminjaman.php">Peminjaman</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="dashboard" class="container my-5">
        <h2 class="text-center mb-4">Dashboard Admin</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card p-4 text-center">
                    <h5 class="card-title">Total Barang</h5>
                    <p class="display-4"><?php echo $totalBarang; ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 text-center">
                    <h5 class="card-title">Total Peminjaman</h5>
                    <p class="display-4"><?php echo $totalPeminjaman; ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4 text-center">
                    <h5 class="card-title">Total Pengguna</h5>
                    <p class="display-4"><?php echo $totalPengguna; ?></p>
                </div>
            </div>
        </div>

        <div class="row mt-5 justify-content-center">
    <div class="col-md-4">
        <div class="card p-4 text-center">
            <h5 class="card-title">Admin Pengguna</h5>
            <div class="d-flex justify-content-center">
                <a href="loginAdmin.php" class="btn btn-orange px-4 py-2">Masuk</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4 text-center">
            <h5 class="card-title">Admin Barang</h5>
            <div class="d-flex justify-content-center">
                <a href="loginAdmin.php" class="btn btn-orange px-4 py-2">Masuk</a>
            </div>
        </div>
    </div>
</div>

        </div>
    </div>
</div>

    </div>
</div>

            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
