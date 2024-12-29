c<?php
// Koneksi database
$conn = new mysqli("localhost", "root", "", "projek_ptc");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi untuk menghitung kelayakan barang
function prediksiKelayakan($usia, $jumlah_pemakaian, $harga, $jumlah_barang, $kategori) {
    $skor_kelayakan = 100;

    // Faktor usia barang
    if ($usia > 5) {
        $skor_kelayakan -= 25;  // Kurang layak jika usia lebih dari 5 tahun
    } elseif ($usia <= 1) {
        $skor_kelayakan += 10;  // Lebih layak jika usia kurang dari 1 tahun
    }

    // Faktor jumlah pemakaian
    if ($jumlah_pemakaian > 50) {
        $skor_kelayakan -= 30;  // Kurang layak jika pemakaian lebih dari 10
    } elseif ($jumlah_pemakaian <= 3) {
        $skor_kelayakan += 5;   // Lebih layak jika pemakaian kurang dari 3 kali
    }

    // Faktor harga barang
    if ($harga > 5000000) {
        $skor_kelayakan += 10;  // Lebih layak jika harga barang mahal
    } elseif ($harga < 1000000) {
        $skor_kelayakan -= 10;  // Kurang layak jika harga barang murah
    }

    // Faktor jumlah barang tersedia
    if ($jumlah_barang < 5) {
        $skor_kelayakan -= 15;  // Kurang layak jika barang tersedia sedikit
    } elseif ($jumlah_barang >= 10) {
        $skor_kelayakan += 5;   // Lebih layak jika banyak barang tersedia
    }

    // Penanganan kategori barang
    if ($kategori == "Elektronik") {
        // Elektronik lebih sensitif terhadap kondisi dan harga
        if ($harga < 1000000) {
            $skor_kelayakan -= 20;  // Barang elektronik dengan harga rendah kurang layak
        }
        if ($jumlah_pemakaian > 10) {
            $skor_kelayakan -= 20;  // Barang elektronik dengan pemakaian banyak berisiko
        }
    } elseif ($kategori == "Furnitur") {
        // Furnitur lebih toleran terhadap pemakaian
        if ($jumlah_pemakaian > 50) {
            $skor_kelayakan -= 10;  // Barang furnitur dengan pemakaian lebih dari 20 kali kurang layak
        }
    }

    // Tentukan status kelayakan berdasarkan skor
    if ($skor_kelayakan >= 60) {
        return "Layak";
    } elseif ($skor_kelayakan >= 30) {
        return "Cukup Layak";
    } else {
        return "Butuh Perbaikan";
    }
}

// Proses ketika admin mengisi form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $NAMABARANG = trim($_POST['nama_barang']);
    $KODEBARANG = trim($_POST['kode_barang']);
    $JUMLAHPEMAKAIAN = intval($_POST['jumlah']);
    $USIABARANG = intval($_POST['usia']);
    $HARGA = intval($_POST['harga']);
    $KATEGORI = trim($_POST['kategori']);

    // Validasi data
    if (empty($NAMABARANG) || empty($KODEBARANG) || empty($JUMLAHPEMAKAIAN) || empty($USIABARANG) || empty($HARGA) || empty($KATEGORI)) {
        echo "Semua field wajib diisi!";
    } else {
        // Prediksi kelayakan barang
        $status_kelayakan = prediksiKelayakan($USIABARANG, $JUMLAHPEMAKAIAN, $HARGA, $JUMLAHPEMAKAIAN, $KATEGORI);

        // Menyimpan data barang ke database
        $stmt = $conn->prepare("INSERT INTO daftarbarangg (NAMABARANG, KODEBARANG, JUMLAHPEMAKAIAN, USIABARANG, HARGA, KATEGORI, status_kelayakan) 
                                VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiiss", $NAMABARANG, $KODEBARANG, $JUMLAHPEMAKAIAN, $USIABARANG, $HARGA, $KATEGORI, $status_kelayakan);

        if ($stmt->execute()) {
            echo "Barang berhasil ditambahkan! Status Kelayakan: " . $status_kelayakan;
        } else {
            echo "Terjadi kesalahan: " . $stmt->error;
        }
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
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color:rgb(224, 224, 224);
            color: #495057;
            font-family: 'Arial', sans-serif;
        }
        h2 {
            color:rgb(0, 0, 0);
            text-align: center;
            margin-bottom: 30px;
        }
        .container {
            max-width: 600px;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-label {
            font-size: 1rem;
            font-weight: bold;
            color: #495057;
        }
        .form-control {
            border: 3px solid #ced4da;
            border-radius: 4px;
            padding: 12px;
            font-size: 1rem;
            margin-bottom: 15px;
        }
        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 5px rgba(0, 123, 255, .25);
        }
        .btn-custom {
            background-color:rgb(0, 0, 0);
            color: #fff;
            font-weight: bold;
            border: none;
            padding: 10px 20px;
            width: 100%;
            border-radius: 4px;
        }
        .btn-custom:hover {
            background-color:rgb(0, 0, 0);
        }
        .alert-info {
            background-color: #e2f3e3;
            border-color: #c3e6cb;
            color:rgb(0, 0, 0);
            font-size: 1rem;
            padding: 15px;
            margin-top: 20px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Tambah Barang</h2>

        <!-- Form Tambah Barang -->
        <form method="POST">
            <div class="mb-3">
                <label for="nama_barang" class="form-label">Nama Barang</label>
                <input type="text" id="nama_barang" name="nama_barang" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="kode_barang" class="form-label">Kode Barang</label>
                <input type="text" id="kode_barang" name="kode_barang" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah Pemakaian</label>
                <input type="number" id="jumlah" name="jumlah" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="usia" class="form-label">Usia Barang (tahun)</label>
                <input type="number" id="usia" name="usia" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="harga" class="form-label">Harga Barang (Rp)</label>
                <input type="number" id="harga" name="harga" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori Barang</label>
                <select id="kategori" name="kategori" class="form-control" required>
                    <option value="" disabled selected>Pilih Kategori</option>
                    <option value="Elektronik">Elektronik</option>
                    <option value="Non Elektronik">Furnitur</option>
                </select>
            </div>
            <button type="submit" class="btn btn-custom">Tambah Barang</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($status_kelayakan)) {
            echo "<div class='mt-3 alert alert-info'>Status Kelayakan Barang: $status_kelayakan</div>";
        }
        ?>
    </div>
</body>
</html>
