<?php
session_start();

$error = '';

$pdo = new PDO('mysql:host=localhost;dbname=projek_ptc', 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $jenis_admin = $_POST['jenis_admin'];

    $valid_admins = [
        'admin_pengguna' => 'adminpassword1',
        'admin_barang' => 'adminpassword2'
    ];

    if (array_key_exists($username, $valid_admins) && $valid_admins[$username] === $password) {
        $query = "SELECT * FROM adminbaruu WHERE username = :username AND jenis_admin = :jenis_admin";
        $stmt = $pdo->prepare($query);
        $stmt->execute([':username' => $username, ':jenis_admin' => $jenis_admin]);

        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            $_SESSION['username'] = $admin['username'];
            $_SESSION['jenis_admin'] = $admin['jenis_admin'];
            if ($username === 'admin_pengguna') {
                header("Location: adminPengguna.php");
            } elseif ($username === 'admin_barang') {
                header("Location: adminBarang.php");
            }
            exit();
        } else {
            $error = "Username atau jenis admin tidak sesuai.";
        }
    } else {
        $error = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color:rgb(217, 217, 217);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color:rgb(149, 149, 149);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            margin-bottom: 20px;
            text-align: center;
            color:rgb(255, 255, 255);
        }

        .login-container form {
            display: flex;
            flex-direction: column;
        }

        .login-container input,
        .login-container select,
        .login-container button {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #BDC4D4;
            border-radius: 5px;
        }

        .login-container button {
            background-color:rgb(0, 0, 0);
            color:rgb(255, 255, 255);
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-container button:hover {
            background-color:rgb(61, 61, 61);
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login Admin</h2>
        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="jenis_admin" required>
                <option value="" disabled selected>Pilih Jenis Admin</option>
                <option value="Admin Pengguna">Admin Pengguna</option>
                <option value="Admin Barang">Admin Barang</option>
            </select>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
