<?php
// Koneksi ke database
$conn = new mysqli('localhost', 'root', '', 'projek_ptc');
if ($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}

// Query untuk mendapatkan data pengguna
$query = "SELECT * FROM users"; // Pastikan nama tabel sesuai
$result = $conn->query($query);

if (!$result) {
    die('Query gagal: ' . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengguna</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Global Styles */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            background-color: #000;
            color: white;
            width: 250px;
            height: 150vh;
            position: fixed;
            transition: transform 0.3s ease-in-out;
            transform: translateX(0);
            z-index: 1000;
        }

        .sidebar.closed {
            transform: translateX(-250px);
        }

        .sidebar h4 {
            text-align: center;
            margin-top: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 15px;
            display: block;
            text-align: left;
        }

        .sidebar a:hover {
            background-color: #444;
        }

        .toggle-btn {
            background-color: #000;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1100;
        }

        /* Main Content Styles */
        main {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
            transition: margin-left 0.3s ease-in-out;
        }

        main.full-width {
            margin-left: 0;
            width: 100%;
        }

        /* Header Styles */
        .page-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: bold;
            position: relative;
        }

        .page-title::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background-color: #000;
            margin: 10px auto 0;
        }

        .page-title {
            color: #333;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
        }

        /* Table Styles */
        .table {
            background-color: #fff;
        }

        .table th {
            background-color: #000;
            color: white;
        }
    .btn-icon {
        color: navy; /* Warna navy */
        font-size: 18px; /* Ukuran ikon */
        border: none; /* Hilangkan border */
        background: none; /* Hilangkan background */
        padding: 5px;
        cursor: pointer;
    }

    .btn-icon:hover {
        color: darkblue; /* Warna saat hover */
    }
</style>

    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h4> Menu Admin </h4>
        <a href="daftar_pengembalian.php">Pengembalian Barang</a>
        <a href="daftarPeminjaman.php">Permintaan Peminjaman</a>
        <a href="logout.php">Logout</a>
    </div>

    <!-- Toggle Button -->
    <button class="toggle-btn" id="toggleSidebar">☰</button>

    <!-- Main Content -->
    <main id="mainContent">
        <h1 class="page-title">Daftar Pengguna</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Lengkap</th>
                    <th>NIM</th>
                    <th>Email</th>
                    <th>Nomor Telepon</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nama_lengkap']; ?></td>
                            <td><?php echo $row['nim']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['nomor_telepon']; ?></td>
                            <td>
                            <td>
    <a href="editPengguna.php?id=<?php echo $row['id']; ?>" class="btn-icon">
        <i class="fas fa-edit"></i>
    </a>
    <a href="hapusPengguna.php?id=<?php echo $row['id']; ?>" class="btn-icon" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
        <i class="fas fa-trash-alt"></i>
    </a>
</td>


                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data pengguna.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <script>
        // Script to toggle sidebar visibility
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('closed');
            mainContent.classList.toggle('full-width');
        });
    </script>
</body>
</html>
