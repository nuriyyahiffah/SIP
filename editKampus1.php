<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Barang Kampus - Admin</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Body Styling */
    body {
        background-color: #f4f4f4;
        color: #333;
        line-height: 1.6;
        font-size: 16px;
    }

    /* Header Styling */
    header {
        background-color: #d07711;
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
        height: 50px;
        margin-right: 15px;
    }

    header h1 {
        font-size: 1.8em;
    }

    .auth-links a {
        color: white;
        text-decoration: none;
        margin-left: 20px;
        font-weight: bold;
        transition: color 0.3s ease;
    }

    .auth-links a:hover {
        color: #004080; /* Darker color for hover effect */
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
        background-color: #d07711;
        transition: background-color 0.3s ease;
    }

    nav ul li a:hover {
        background-color: #e6891b; /* Lighter orange for hover effect */
    }

    .dropdown-content {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background-color: #e6891b;
        min-width: 180px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        z-index: 1;
        border-radius: 5px;
        transition: opacity 0.3s ease;
    }

    .dropdown-content a {
        color: white;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .dropdown-content a:hover {
        background-color: #f4a53e; /* Even lighter orange for hover */
    }

    nav ul li:hover .dropdown-content {
        display: block;
    }

    /* Container Styling */
    .container {
        padding: 20px;
        border-radius: 8px;
        transition: 0.3s;
    }

    h1 {
        text-align: center;
        color: #d07711;
        font-size: 24px;
        margin-bottom: 20px;
    }

    .search-form {
        text-align: center;
        margin-bottom: 20px;
    }

    .search-form input[type="text"] {
        padding: 10px;
        width: 50%;
        border: 1px solid #b0bec5;
        border-radius: 4px;
        font-size: 16px;
    }

    .search-form button {
        padding: 10px 15px;
        border: none;
        background-color: #d07711;
        color: white;
        font-weight: bold;
        cursor: pointer;
        border-radius: 4px;
        font-size: 16px;
    }

    .search-form button:hover {
        background-color: #e6891b;
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
        border: 1px solid #b0bec5;
    }

    th {
        background-color: #d07711;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #fef6ea;
    }

    tr:hover {
        background-color: #fbe1c7;
    }

    .btn-pinjam, .btn-back, .btn-edit, .btn-delete {
        padding: 8px 12px;
        background-color: #d07711;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    .btn-pinjam:hover, .btn-back:hover, .btn-edit:hover, .btn-delete:hover {
        background-color: #e6891b;
    }

    /* Form to add new items */
    .add-item-form {
        margin-top: 30px;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .add-item-form input, .add-item-form select {
        padding: 10px;
        margin: 10px 0;
        width: 100%;
        border: 1px solid #b0bec5;
        border-radius: 4px;
        font-size: 16px;
    }

    .add-item-form button {
        background-color: #d07711;
        color: white;
        font-weight: bold;
        cursor: pointer;
        border: none;
        border-radius: 4px;
        padding: 10px 15px;
    }

    .add-item-form button:hover {
        background-color: #e6891b;
    }
</style>
</head>
<body>

    <!-- Header -->
    <header>
        <div class="logo">
            <img src="images/Logo_Bulat.png" alt="Logo SI Pinjam">
            <h1>SIP KAMPUS ITH</h1>
        </div>
        <div class="auth-links">
            <a href="login.php">Login</a>
            <a href="register.php">Sign In</a>
        </div>
        <nav>
            <ul>
                <li><a href="adminBarang.php">Dashboard</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <div class="container">
        <h1>Daftar Barang di Kampus 1</h1>

        <!-- Form to add new item -->
        <div class="add-item-form">
            <h2>Tambah Barang</h2>
            <form method="POST" action="adminBarang.php">
                <input type="text" name="kode_barang" placeholder="Kode Barang" required>
                <input type="text" name="nama" placeholder="Nama Barang" required>
                <input type="number" name="jumlah" placeholder="Jumlah Barang" required>
                <input type="text" name="usia" placeholder="Usia Barang (Optional)">
                <select name="status">
                    <option value="Available">Available</option>
                    <option value="Unavailable">Unavailable</option>
                </select>
                <button type="submit" name="add">Tambah Barang</button>
            </form>
        </div>

        <!-- Search Form -->
        <form method="GET" action="adminBarang.php" class="search-form">
            <input type="text" name="search" placeholder="Cari Barang...">
            <button type="submit">Cari</button>
        </form>

        <!-- Item List -->
        <table>
            <thead>
            <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Usia Barang</th>
                    <th>Status Barang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                 $barangKampus1 = [
                    ["no" => 1, "kode_barang" => "FS001", "nama" => "Focusing Screen/Layar LCD Projector", "jumlah" => 2, "usia" => "-", "status" => "Available"],
                    ["no" => 2, "kode_barang" => "LCD002", "nama" => "LCD Projector/Infocus", "jumlah" => 7, "usia" => "-", "status" => "Available"],
                    ["no" => 3, "kode_barang" => "KB001", "nama" => "Kabel VGA", "jumlah" => 5, "usia" => "-", "status" => "Available"]
                ];

                foreach ($barangKampus1 as $item) {
                    echo "<tr>";
                    echo "<td>{$item['no']}</td>";
                    echo "<td>{$item['kode_barang']}</td>";
                    echo "<td>{$item['nama']}</td>";
                    echo "<td>{$item['jumlah']}</td>";
                    echo "<td>{$item['usia']}</td>";
                    echo "<td>{$item['status']}</td>";
                    echo "<td>
                            <a href='#' class='btn-edit'>Edit</a> |
                            <a href='#' class='btn-delete'>Hapus</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
