<?php
session_start();
include 'db_connection.php';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang Kampus 1</title>
    <style>
      /* General Styling */
      * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }
        body {
            background-color:rgb(255, 255, 255);
            color: #333;
            line-height: 1.6;
        }
        a {
            text-decoration: none;
            color: inherit;
        }

        /* Header Styling */
        header {
            background-color: #000000;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
        header .logo {
            display: flex;
            align-items: center;
        }
        header .logo img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }
        header h1 {
            font-size: 24px;
            color: white; /* Pastikan warna font di header h1 menjadi putih */

        }
        header nav ul {
            display: flex;
            list-style: none;
        }
        header nav ul li {
            margin-left: 20px;
        }
        header nav ul li a {
            padding: 10px;
            transition: all 0.3s ease;
        }
        header nav ul li a:hover {
            color: #52677D;
        }

        /* Container Styling */
        .container {
            margin: 20px auto;
            padding: 20px;
            width: 90%;
            max-width: 1100px;
            background: white;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: rgba(15, 14, 14, 0.9);
            margin-bottom: 20px;
        }
        .search-form {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .search-form input {
            padding: 10px;
            width: 60%;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 10px;
        }
        .search-form button {
            padding: 10px 15px;
            background-color: rgba(15, 14, 14, 0.9);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .search-form button:hover {
            background-color:rgb(186, 186, 186);
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: rgba(0, 0, 0, 0.9);
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #BDC4D4;
        }
        .btn-pinjam {
            display: inline-block;
            padding: 8px 12px;
            background-color: rgba(15, 14, 14, 0.9);
            color: white;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        .btn-pinjam:hover {
            background-color:rgb(157, 157, 157);
        }
        .btn-back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #000000;
            color: white;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .btn-back:hover {
            background-color:rgb(10, 74, 142);
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
                <?php if (!isset($_SESSION['nim'])) { ?>
                    <li><a href="login.php">Login</a></li>
                <?php } else { ?>
                    <li><a href="logout.php">Log Out</a></li>
                <?php } ?>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h1>Daftar Barang Kampus 1</h1>
        <form method="GET" class="search-form">
            <input type="text" name="search" placeholder="Cari Barang...">
            <button type="submit">Cari</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Kategori</th>
                </tr>
            </thead>
            <tbody>
                <?php
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$query = "SELECT * FROM daftarbarangg WHERE NAMABARANG LIKE '%$search%'";

                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                            <td>{$no}</td>
                            <td>{$row['KODEBARANG']}</td>
                            <td>{$row['NAMABARANG']}</td>
                            <td>{$row['KATEGORI']}</td>
                            <td><a href='peminjaman1.php?KODEBARANG={$row['KODEBARANG']}' class='btn-pinjam'>Pinjam</a></td>
                        </tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='7'>Barang tidak ditemukan.</td></tr>";
                }
                mysqli_free_result($result);
                mysqli_close($conn);
                ?>
            </tbody>
        </table>

        <a href="index.php" class="btn-back">Kembali</a>
    </div>
</body>
</html>
