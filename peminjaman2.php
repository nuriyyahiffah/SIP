<?php
session_start();

// Periksa apakah user sudah login
if (!isset($_SESSION['nim'])) {
    header("Location: login.php");
    exit();
}

// Mendapatkan nama user dari session
$userName = $_SESSION['nama_lengkap'] ?? '';

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projek_ptc";

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("<p>Koneksi ke database gagal: " . $conn->connect_error . "</p>");
}

// Default barang dan kode_barang
$barang = 'Barang Tidak Diketahui';
$kode_barang = '';

// Periksa apakah kode_barang ada di URL
if (isset($_GET['KODEBARANG'])) {
    $kode_barang = filter_input(INPUT_GET, 'KODEBARANG', FILTER_SANITIZE_STRING);

    // Ambil nama barang dari database
    $stmt = $conn->prepare("SELECT NAMABARANG FROM daftarbarang WHERE KODEBARANG = ?");
    $stmt->bind_param("s", $kode_barang);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $barang = $row['NAMABARANG'];
    } else {
        $barang = 'Barang tidak ditemukan';
    }
    $stmt->close();
}

// Proses saat form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validasi dan sanitasi input
    $barang = htmlspecialchars($_POST['barang']);
    $nama_peminjam = htmlspecialchars($_POST['nama']);
    $keperluan = htmlspecialchars($_POST['keperluan']);
    $kode_barang = htmlspecialchars($_POST['kode_barang']);
    $ruang = htmlspecialchars($_POST['ruang']);
    $mulai_tanggal = htmlspecialchars($_POST['mulai_tanggal']);
    $sampai_tanggal = htmlspecialchars($_POST['sampai_tanggal']);
    $mulai_jam = htmlspecialchars($_POST['mulai_jam']);
    $akhir_jam = htmlspecialchars($_POST['akhir_jam']);

    // Cek apakah semua field telah diisi
    if (empty($barang) || empty($nama_peminjam) || empty($keperluan) || empty($kode_barang) || empty($ruang) || empty($mulai_tanggal) || empty($sampai_tanggal) || empty($mulai_jam) || empty($akhir_jam)) {
        echo "<p>Semua kolom harus diisi!</p>";
    } else {
        // Masukkan data ke database
        $stmt = $conn->prepare(
            "INSERT INTO peminjaman2 (barang, nama_peminjam, keperluan, kode_barang, ruang, mulai_tanggal, sampai_tanggal, mulai_jam, akhir_jam)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            "sssssssss",
            $barang,
            $nama_peminjam,
            $keperluan,
            $kode_barang,
            $ruang,
            $mulai_tanggal,
            $sampai_tanggal,
            $mulai_jam,
            $akhir_jam
        );

        if ($stmt->execute()) {
            echo "<p>Peminjaman berhasil diajukan!</p>";
            echo "<a href='index.php'>Kembali ke Halaman Utama</a>";
        } else {
            echo "<p>Terjadi kesalahan: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Form Peminjaman Barang</title>
        <style>
            /* CSS yang sudah ada */
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            body {
                background-color:rgb(216, 216, 216);
                color: #1C2E4A;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                margin-top: 20px;
            }
            .container {
                width: 100%;
                max-width: 500px;
                padding: 20px;
                background-color: #ffffff;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
                margin: 0 15px;
            }
            h1 {
                text-align: center;
                color: #1C2E4A;
                font-size: 24px;
                margin-bottom: 20px;
            }
            form {
                display: flex;
                flex-direction: column;
            }
            label {
                font-weight: bold;
                color: #1C2E4A;
                margin-bottom: 5px;
            }
            input[type="text"], input[type="date"], input[type="time"], select {
                padding: 10px;
                border: 1px solid #52677D;
                border-radius: 4px;
                font-size: 16px;
                margin-bottom: 15px;
                color: #1C2E4A;
            }
            input:focus, select:focus {
                outline: 2px solid #52677D;
            }
            button {
                padding: 12px;
                border: none;
                background-color:rgb(0, 0, 0);
                color: white;
                font-size: 16px;
                font-weight: bold;
                cursor: pointer;
                border-radius: 4px;
                transition: background-color 0.3s ease;
            }
            button:hover {
                background-color: #1C2E4A;
            }
            p {
                text-align: center;
                margin-bottom: 10px;
                color: #1C2E4A;
            }
            a {
                display: block;
                text-align: center;
                color: #52677D;
                text-decoration: none;
                margin-top: 10px;
                font-weight: bold;
            }
            a:hover {
                color: #1C2E4A;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Form Peminjaman Barang</h1>
            <form method="POST" action="peminjaman2.php">
                <label for="barang">Barang yang Dipinjam:</label>
                <input type="text" id="barang" name="barang" value="<?php echo htmlspecialchars($barang); ?>" readonly>

                <label for="nama">Nama Peminjam:</label>
                <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($userName); ?>" required>

                <label for="keperluan">Keperluan:</label>
                <input type="text" id="keperluan" name="keperluan" required>

                <label for="kode_barang">Kode Barang:</label>
                <input type="text" id="kode_barang" name="kode_barang" value="<?php echo htmlspecialchars($kode_barang); ?>" required>

                <label for="ruang">Pilih Ruangan:</label>
                <select id="ruang" name="ruang" required>
                    <option value="Ruang 101">Ruang 101</option>
                    <option value="Ruang 102">Ruang 102</option>
                    <option value="Ruang 103">Ruang 103</option>
                    <option value="Ruang 104">Ruang 104</option>
                    <option value="Ruang 202">Ruang 202</option>
                    <option value="Ruang 203">Ruang 203</option>
                    <option value="Ruang 205">Ruang 205</option>
                    <option value="Ruang 206">Ruang 206</option>
                    <option value="Aula">Aula</option>
                </select>

                <label for="mulai_tanggal">Mulai Tanggal:</label>
                <input type="date" id="mulai_tanggal" name="mulai_tanggal" required>

                <label for="sampai_tanggal">Sampai Tanggal:</label>
                <input type="date" id="sampai_tanggal" name="sampai_tanggal" required>

                <label for="mulai_jam">Mulai Jam:</label>
                <input type="time" id="mulai_jam" name="mulai_jam" required>

                <label for="akhir_jam">Akhir Jam:</label>
                <input type="time" id="akhir_jam" name="akhir_jam" required>

                <button type="submit">Ajukan Peminjaman</button>
            </form>
        </div>
    </body>
    </html>
<?php
}
$conn->close();
?>
