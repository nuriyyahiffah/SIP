<?php
session_start();
include 'config.php';

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi jika input tidak kosong
    if (!empty($_POST['nim']) && !empty($_POST['password'])) {
        $nim = htmlspecialchars(trim($_POST['nim']));
        $password = htmlspecialchars(trim($_POST['password']));

        // Persiapkan pernyataan SQL untuk mencegah SQL Injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE nim = ?");
        $stmt->bind_param("s", $nim);
        $stmt->execute();
        $result = $stmt->get_result();

        // Periksa apakah pengguna ditemukan
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verifikasi password
            if (password_verify($password, $user['password'])) {
                // Set sesi pengguna
                $_SESSION['nim'] = $user['nim'];
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                $_SESSION['logged_in'] = true;
                header("Location: index.php");
                exit;
            } else {
                $error_message = "Password salah. Silakan coba lagi.";
            }
        } else {
            $error_message = "Akun dengan NIM tersebut tidak ditemukan.";
        }

        $stmt->close();
    } else {
        $error_message = "Harap isi NIM dan Password dengan benar.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Peminjaman Barang Kampus</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="" method="post">

            <div class="input-group">
                <input type="text" name="nim" placeholder="NIM" required>
                <i class="fas fa-id-card icon"></i>
            </div>

            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
                <i class="fas fa-lock icon"></i>
            </div>

            <?php if (!empty($error_message)): ?>
                <p class="error-message"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <button type="submit">Login</button>
        </form>
        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </div>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: rgb(207, 205, 205);
        }
        .container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        form {
            width: 100%;
        }
        .input-group {
            position: relative;
            margin-bottom: 20px;
        }
        .input-group input {
            width: 100%;
            padding: 10px 40px 10px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            background-color:rgb(209, 209, 209); /* Warna latar belakang baru */
            color:rgb(0, 0, 0); /* Warna teks baru */
        }

        .input-group .icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            color:rgb(54, 54, 54);
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 20px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color:rgb(0, 0, 0);
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color:  #1C2E4A;
        }
        p {
            margin-top: 20px;
            font-size: 14px;
        }
        p a {
            color: #007bff;
            text-decoration: none;
        }
        p a:hover {
            text-decoration: underline;
        }
    </style>
</body>
</html>