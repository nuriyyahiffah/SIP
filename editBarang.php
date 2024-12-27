<?php
// Mock data for barang
$barangKampus1 = [
    ["id" => 1, "kode_barang" => "FS001", "nama" => "Focusing Screen/Layar LCD Projector", "jumlah" => 2, "usia" => "-", "status" => "Available"],
    ["id" => 2, "kode_barang" => "LCD002", "nama" => "LCD Projector/Infocus", "jumlah" => 7, "usia" => "-", "status" => "Available"],
    ["id" => 3, "kode_barang" => "KC003", "nama" => "Kursi Kerja (Roda)", "jumlah" => 25, "usia" => "-", "status" => "Unavailable"],
    ["id" => 4, "kode_barang" => "CB004", "nama" => "Chrome Book", "jumlah" => 337, "usia" => "2022", "status" => "Available"],
    ["id" => 5, "kode_barang" => "TP005", "nama" => "Tablet PC", "jumlah" => 87, "usia" => "-", "status" => "Available"],
];

$error = ''; // Variable to store error messages

// If form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $id = $_POST['id'];
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah'];
    $usia = $_POST['usia'];
    $status = $_POST['status'];

    // Example validation
    if (empty($kode_barang) || empty($nama_barang) || empty($jumlah) || empty($status)) {
        $error = 'All fields are required.';
    } else {
        // Update the barang data
        // In a real scenario, this would be done via a database update query
        $barangKampus1[$id - 1] = [
            "id" => $id,
            "kode_barang" => $kode_barang,
            "nama" => $nama_barang,
            "jumlah" => $jumlah,
            "usia" => $usia,
            "status" => $status
        ];
        header("Location: adminBarang.php"); // Redirect back to the admin barang page
    }
}

// Retrieve the current data for editing
$id = isset($_GET['id']) ? $_GET['id'] : 1;
$barang = $barangKampus1[$id - 1];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang Kampus</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to external CSS -->
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
        color: #004080;
    }

    /* Form Styling */
    h1 {
        text-align: center;
        color: #d07711;
        font-size: 24px;
        margin-bottom: 20px;
    }

    form {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 50%;
        margin: 0 auto;
    }

    form label {
        font-weight: bold;
        display: block;
        margin: 10px 0 5px;
    }

    form input[type="text"],
    form input[type="number"],
    form select {
        width: 100%;
        padding: 10px;
        border: 1px solid #b0bec5;
        border-radius: 4px;
        font-size: 16px;
        margin-bottom: 15px;
    }

    form button {
        padding: 10px 15px;
        border: none;
        background-color: #d07711;
        color: white;
        font-weight: bold;
        cursor: pointer;
        border-radius: 4px;
        font-size: 16px;
        width: 100%;
    }

    form button:hover {
        background-color: #e6891b;
    }

    /* Error Message Styling */
    .error {
        color: red;
        text-align: center;
        margin-top: 15px;
    }

    /* Back Button Styling */
    a.btn-back {
        display: inline-block;
        padding: 8px 15px;
        background-color: #d07711;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        text-align: center;
        margin-top: 20px;
    }

    a.btn-back:hover {
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
    </header>

    <!-- Main Content -->
    <div class="container">
        <h1>Edit Barang Kampus</h1>
        
        <!-- Display error message if any -->
        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <!-- Edit Barang Form -->
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?= $barang['id'] ?>">

            <label for="kode_barang">Kode Barang</label>
            <input type="text" name="kode_barang" id="kode_barang" value="<?= $barang['kode_barang'] ?>" required>

            <label for="nama_barang">Nama Barang</label>
            <input type="text" name="nama_barang" id="nama_barang" value="<?= $barang['nama'] ?>" required>

            <label for="jumlah">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" value="<?= $barang['jumlah'] ?>" required>

            <label for="usia">Usia Barang</label>
            <input type="text" name="usia" id="usia" value="<?= $barang['usia'] ?>">

            <label for="status">Status</label>
            <select name="status" id="status" required>
                <option value="Available" <?= $barang['status'] == 'Available' ? 'selected' : '' ?>>Available</option>
                <option value="Unavailable" <?= $barang['status'] == 'Unavailable' ? 'selected' : '' ?>>Unavailable</option>
            </select>

            <button type="submit">Update Barang</button>
        </form>

        <a href="adminBarang.php" class="btn-back">Kembali</a>
    </div>

</body>
</html>
