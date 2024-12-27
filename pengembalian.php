<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projek_ptc";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Cek apakah pengguna sudah login
if (!isset($_SESSION['nama_lengkap'])) {
    header('Location: login.php');
    exit;
}

// Validasi metode dan parameter yang dikirimkan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['table'])) {
    // Validasi dan sanitasi input
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);
    $table = htmlspecialchars($_POST['table']);

    // Validasi nama tabel yang diperbolehkan
    if (!in_array($table, ['peminjaman1', 'peminjaman2'])) {
        echo "<script>
                alert('Tabel tidak valid.');
                window.location.href = 'barang_yang_dipinjam.php';
              </script>";
        exit;
    }

    // Pastikan ID valid
    if (!$id) {
        echo "<script>
                alert('ID tidak valid.');
                window.location.href = 'barang_yang_dipinjam.php';
              </script>";
        exit;
    }

    // Ambil data peminjaman dari database
    $sql = "SELECT * FROM $table WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
        } else {
            echo "<script>
                    alert('Data peminjaman tidak ditemukan.');
                    window.location.href = 'barang_yang_dipinjam.php';
                  </script>";
            exit;
        }
    } else {
        echo "<script>
                alert('Terjadi kesalahan dalam query database.');
                window.location.href = 'barang_yang_dipinjam.php';
              </script>";
        exit;
    }
} else {
    echo "<script>
            alert('Akses halaman ini tidak valid.');
            window.location.href = 'barang_yang_dipinjam.php';
          </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Pengembalian Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
        body {
            background-color: #f4f7fb;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #000000;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header .logo {
            display: flex;
            align-items: center;
        }

        .header .logo img {
            height: 50px;
            margin-right: 15px;
        }

        .header h1 {
            font-size: 1.8em;
            margin: 0;
        }
        nav ul {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
}

nav ul li {
    position: relative;
    margin-left: 10px;
}

nav ul li a {
    color: white;
    text-decoration: none;
    font-weight: bold;
    padding: 12px 18px;
    display: inline-block;
    border-radius: 5px;
    background-color: #000000;  /* Black */
    transition: background-color 0.3s ease;
}

nav ul li a:hover {
    background-color: #1C2E4A;  /* Dark blue hover */
}

        .container {
            margin-top: 200px; /* Ruang untuk header */
            max-width: 450px;
            padding: 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        .input-group input {
            padding: 10px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            background-color: #f9f9f9;
        }

        .input-group .icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            color: #52677D;
        }

        .btn-kembali {
            width: 100%;
            padding: 12px;
            background-color: #000000;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-kembali:hover {
            background-color: #1C2E4A;
        }

        footer {
            background-color: #000000;
            color: white;
            padding: 10px;
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="images/Logo_Bulat.png" alt="Logo SI Pinjam">
            <h1>SIP KAMPUS ITH</h1>
        </div>
    </header>

    <div class="container">
        <h2>Form Pengembalian Barang</h2>
        <p>Silakan kirim bukti gambar untuk menyelesaikan proses pengembalian barang.</p>
        <form method="POST" action="proses_pengembalian.php" enctype="multipart/form-data">
            <!-- Input hidden untuk ID -->
            <input type="hidden" name="id" value="<?php echo isset($data['id']) ? $data['id'] : ''; ?>">
            <!-- Input hidden untuk nama tabel -->
            <input type="hidden" name="table" value="<?php echo isset($table) ? $table : ''; ?>">

            <!-- Nama Barang -->
            <div class="input-group">
                <input type="text" id="barang" name="barang" class="form-control" value="<?php echo isset($data['barang']) ? $data['barang'] : ''; ?>" readonly>
                <i class="fas fa-box icon"></i>
            </div>

            <!-- Tanggal Pengembalian -->
            <div class="input-group">
                <input type="date" id="tanggal_pengembalian" name="tanggal_pengembalian" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly>
                <i class="fas fa-calendar-alt icon"></i>
            </div>

            <!-- Input Foto Pengembalian -->
            <div class="input-group">
                <input type="file" id="foto_pengembalian" name="foto_pengembalian" class="form-control">
                <i class="fas fa-camera icon"></i>
            </div>

            <!-- Button -->
            <button type="submit" name="submit" class="btn-kembali">Kembalikan Barang</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Sistem Peminjaman Barang Kampus</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
