<?php 
session_start();

$servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "projek_ptc";
$conn = new mysqli($servername, $db_username, $db_password, $db_name);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$nim = $_SESSION['nim'];
$sql = "SELECT nama_lengkap, nim, email, nomor_telepon, foto_profil FROM users WHERE nim = '$nim'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    $user = array(
        'nama_lengkap' => 'Nama Pengguna',
        'nim' => 'NIM',
        'email' => 'Email',
        'nomor_telepon' => 'Nomor Telepon',
        'foto_profil' => 'default.jpg'
    );
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['profile-image'])) {
        $file_name = $_FILES['profile-image']['name'];
        $file_tmp = $_FILES['profile-image']['tmp_name'];
        move_uploaded_file($file_tmp, "uploads/" . $file_name);

        $sql_update = "UPDATE users SET foto_profil='$file_name' WHERE nim='$nim'";
        if ($conn->query($sql_update) === TRUE) {
            $user['foto_profil'] = $file_name;
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }

    if (isset($_POST['logout'])) {
        session_destroy();
        header('Location: login.php');
        exit;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna - SIP Kampus ITH</title>
    <style> 
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        background-color:rgb(212, 212, 212);
        color:rgb(0, 0, 0);
        line-height: 1.6;
        font-size: 16px;
    } 

    header {
        background-color:rgb(0, 0, 0);
        color: #BDC4D4; 
        padding: 20px 30px;
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
        color:rgb(255, 255, 255); /* Light grayish blue heading */
    }

    nav ul {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    nav ul li {
        position: relative;
        margin-left: 15px;
    }

    nav ul li a {
        color: #BDC4D4; /* Light grayish blue text */
        text-decoration: none;
        font-weight: bold;
        padding: 12px 20px;
        display: inline-block;
        border-radius: 5px;
        background-color:rgb(0, 0, 0); /* Muted blue background */
        transition: background-color 0.3s ease;
    }

    nav ul li a:hover {
        background-color: #1C2E4A; /* Dark blue background on hover */
    }

    /* Profile Container */
    .profile-container {
        width: 100%;
        max-width: 800px;
        margin: 40px auto;
        background: #fff;
        padding: 40px;
        text-align: center;
    }

    .profile-picture {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 20px;
    }

    .profile-info {
        text-align: left;
        margin-bottom: 15px;
    }

    .profile-info label {
        font-size: 16px;
        font-weight: 600;
        color: #1C2E4A; /* Dark blue label text */
        margin-bottom: 5px;
        display: block;
    }

    .profile-info p {
        font-size: 16px;
        color: #52677D; /* Muted blue text */
        margin-top: 5px;
    }

    /* Button Styling */
    button {
        padding: 10px 20px;
        background-color: #BDC4D4; /* Light grayish blue */
        color: #1C2E4A; /* Dark blue text */
        border: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        letter-spacing: 0.5px;
    }

    button:hover {
        background-color: #BDC4D4; /* Dark blue background on hover */
        transform: scale(1.03);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    button:focus {
        outline: none;
    }

    .logout-btn {
        background-color:rgb(211, 161, 161);
        margin-top: 20px;
    }

    .logout-btn:hover {
        background-color: #ff1a1a;
    }

    .item-btn {
        background-color: #BDC4D4; /* Muted blue background */
        margin-top: 10px;
    }

    .item-btn:hover {
        background-color: #BDC4D4; /* Dark blue background on hover */
    }

    /* Footer Styling */
    footer {
        background-color:rgb(0, 0, 0); /* Muted blue background */
        color: #BDC4D4; /* Light grayish blue text */
        text-align: center;
        padding: 15px 0;
        font-size: 1.1em;
        box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.1);
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
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
        
    </header>

    <div class="profile-container">
        <button class="back-btn" onclick="window.location.href='index.php'">Kembali</button>
        
        <h2>Profil Pengguna</h2>

        <img src="uploads/<?php echo $user['foto_profil']; ?>" alt="Foto Profil" class="profile-picture" id="profile-pic">
        <form action="profil_user.php" method="POST" enctype="multipart/form-data">
            <input type="file" id="profile-image" name="profile-image" accept="image/*" onchange="uploadProfileImage()">
            <button type="submit" class="edit-btn">Simpan Foto</button>
        </form>

        <div class="profile-info">
            <label>Nama Lengkap:</label>
            <p><?php echo $user['nama_lengkap']; ?></p>
        </div>
        <div class="profile-info">
            <label>NIM:</label>
            <p><?php echo $user['nim']; ?></p>
        </div>
        <div class="profile-info">
            <label>Email:</label>
            <p><?php echo $user['email']; ?></p>
        </div>
        <div class="profile-info">
            <label>Nomor Telepon:</label>
            <p><?php echo $user['nomor_telepon']; ?></p>
        </div>

        <button class="item-btn" onclick="window.location.href='barang_yang_dipinjam.php'">Barang yang Dipinjam</button>
        <button class="item-btn" onclick="window.location.href='riwayat_peminjaman.php'">Riwayat Peminjaman</button>

        <form action="login.php" method="POST">
        </form>
    </div>

    <footer>
        <p>&copy; 2024 SIP Kampus ITH. All rights reserved.</p>
    </footer>

</body>
</html>
