<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projek_ptc";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['nama_lengkap'])) {
    $user_name = $_SESSION['nama_lengkap']; 
} else {
    header('Location: login.php'); 
    exit;
}

// Query data from both borrowing tables
$sql = "
    SELECT p1.*, b.NAMABARANG, 'peminjaman1' AS table_name 
    FROM peminjaman1 p1
    JOIN daftarbarang b ON p1.kode_barang = b.KODEBARANG
    WHERE p1.nama_peminjam = ?
    UNION
    SELECT p2.*, b.NAMABARANG, 'peminjaman2' AS table_name 
    FROM peminjaman2 p2
    JOIN daftarbarang b ON p2.kode_barang = b.KODEBARANG
    WHERE p2.nama_peminjam = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user_name, $user_name);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang yang Dipinjam</title>
    <style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

html, body {
    height: 100%; /* Pastikan body dan html mengambil 100% tinggi layar */
}

body {
    display: flex;
    flex-direction: column; /* Mengatur tata letak body sebagai kolom */
    background-color: rgb(216, 216, 216); /* Light greyish-blue */
    color: #1C2E4A; /* Dark blue */
    line-height: 1.6;
    font-size: 16px;
}

header {
    background-color: #000000; /* Black */
    color: white;
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

header .logo {
    display: flex;
    align-items: center;
}

header .logo img {
    height: 100px;
    margin-right: 15px;
}

header h1 {
    font-size: 1.8em;
    color: #FFFFFF;
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
    background-color: #000000; /* Black */
    transition: background-color 0.3s ease;
}

nav ul li a:hover {
    background-color: #1C2E4A; /* Dark blue hover */
}

.container {
    padding: 20px;
    border-radius: 8px;
    background-color: white;
    margin-top: 20px;
    box-shadow: 0 4px 6px rgba(109, 109, 110, 0.1);
    flex: 1; /* Mengisi ruang kosong untuk mendorong footer ke bawah */
}

h1 {
    text-align: center;
    color:rgb(0, 0, 0); /* Slate blue */
    font-size: 24px;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 12px;
    text-align: center;
    font-size: 16px;
    border: 1px solid #BDC4D4; /* Light greyish-blue */
}

th {
    background-color:rgb(0, 0, 0); /* Slate blue */
    color: white;
}

tr:nth-child(even) {
    background-color: #FFFFFF;
}

tr:hover {
    background-color: #BDC4D4; /* Light greyish-blue on hover */
}

.btn-back {
    padding: 8px 12px;
    background-color:rgb(0, 0, 0); /* Slate blue */
    color: white;
    text-decoration: none;
    border-radius: 4px;
    transition: background-color 0.3s;
    margin-top: 20px;
    display: inline-block;
}

.btn-back:hover {
    background-color: #1C2E4A; /* Dark blue hover */
}

.btn-return {
    padding: 8px 12px;
    background-color: #52677D; /* Slate blue */
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn-return:hover {
    background-color: rgb(166, 166, 166); /* Grey hover */
}

footer {
    background-color: rgb(0, 0, 0); /* Midnight Blue */
    color: white;
    text-align: center;
    padding: 15px 0;
    font-size: 14px; /* Ukuran font untuk teks footer */
    box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1); /* Efek bayangan di bagian atas */
    width: 100%; /* Memastikan footer mengambil lebar penuh */
}
</style>


    </style>
</head>
<body>

<header>
    <div class="logo">
        <img src="images/Logo_Bulat.png" alt="Logo SI Pinjam">
        <h1>SIP KAMPUS ITH</h1>
    </div>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
                </div>
            </li>
            <li><a href="profil_user.php">Profil</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <h1>Daftar Barang yang Anda Pinjam</h1>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Barang</th>
                    <th>Kode</th>
                    <th>Keperluan</th>
                    <th>Ruang</th>
                    <th>Mulai Tanggal</th>
                    <th>Sampai Tanggal</th>
                    <th>Mulai Jam</th>
                    <th>Akhir Jam</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>";

                while ($row = $result->fetch_assoc()) {
                    // Menyimpan status untuk pengecekan
                    $status = $row['status'] ? $row['status'] : 'Menunggu Persetujuan';
                
                    // Menampilkan status "Disetujui" jika status peminjaman telah disetujui
                    if ($status == 'Disetujui') {
                        $status = 'Disetujui';
                    } elseif ($status == 'Dikembalikan') {
                        $status = 'Dikembalikan';  // Tambahkan kondisi ini
                    } else {
                        $status = 'Menunggu Persetujuan';
                    }
                

            echo "<tr>
                    <td>{$row['barang']}</td>
                    <td>{$row['kode_barang']}</td>
                    <td>{$row['keperluan']}</td>
                    <td>{$row['ruang']}</td>
                    <td>{$row['mulai_tanggal']}</td>
                    <td>{$row['sampai_tanggal']}</td>
                    <td>{$row['mulai_jam']}</td>
                    <td>{$row['akhir_jam']}</td>
                    <td>{$status}</td>
                    <td>";

            // Jika status peminjaman adalah 'Disetujui' dan barang belum dikembalikan
            if ($status == 'Disetujui') {
                echo "<form method='POST' action='pengembalian.php'>
                        <input type='hidden' name='id' value='" . $row['id'] . "'>
                        <input type='hidden' name='table' value='" . $row['table_name'] . "'>
                        <button type='submit' name='pengembalian' class='btn-return'>Kembalikan Barang</button>
                      </form>";
            }

            echo "</td>
                  </tr>";
        }

        echo "</table>";
    } else {
        echo "<p style='text-align: center;'>Anda belum memiliki barang yang dipinjam atau permintaan Anda masih menunggu persetujuan.</p>";
    }

    $stmt->close();
    $conn->close();
    ?>

    <a href="profil_user.php" class="btn-back">Kembali</a>
</div>

<footer>
        <p>&copy; 2024 SIP - Sistem Peminjaman Barang Kampus ITH. All Rights Reserved.</p>
    </footer>

</body>
</html>
