<?php
session_start();

if (!isset($_SESSION['nama_lengkap'])) {
    header('Location: login.php');
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projek_ptc";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM peminjaman1 WHERE nama_peminjam = ? UNION SELECT * FROM peminjaman2 WHERE nama_peminjam = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ss", $_SESSION['nama_lengkap'], $_SESSION['nama_lengkap']);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman</title>
    <style>
        body {
            background-color: rgb(216, 216, 216);
            font-family: Arial, sans-serif;
            color: rgb(0, 0, 0);
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #1C2E4A;
            margin-top: 20px;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #52677D;
        }

        table th {
            background-color: rgb(0, 0, 0);
            color: rgb(255, 255, 255);
        }

        table tbody tr:hover {
            background-color: #1C2E4A;
            color: #BDC4D4;
        }

        table td {
            background-color: #F5F5F5;
        }

        footer {
            background-color: rgb(0, 0, 0);
            text-align: center;
            color: white;
            padding: 15px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        .container {
            padding: 20px;
        }

        /* Header styles */
        header {
            background-color: #000000;
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
            background-color: #000000;
            transition: background-color 0.3s ease;
        }

        nav ul li a:hover {
            background-color: #1C2E4A;
        }
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
            <li><a href="profil_user.php">Profil</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    <h2>Riwayat Peminjaman Anda</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['barang']; ?></td>
                    <td><?php echo $row['mulai_tanggal']; ?></td>
                    <td><?php echo $row['sampai_tanggal']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<footer>
    <p>&copy; 2024 SIP - Sistem Peminjaman Barang Kampus ITH. All Rights Reserved.</p>
</footer>

</body>
</html>

<?php
$conn->close();
?>
