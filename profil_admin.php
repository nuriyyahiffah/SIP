<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    // Redirect to login page if admin is not logged in
   // header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Profile</title>
    <p>Welcome, <?php echo $_SESSION['admin_name']; ?>!</p>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Basic Reset */
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
            min-height: 100vh;
            background-color: #f4f6f9;
        }

        .profile-card {
            width: 300px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .profile-card h1 {
            font-size: 24px;
            margin-bottom: 10px;
            color: #333;
        }

        .profile-card p {
            color: #666;
            margin-bottom: 20px;
        }

        .profile-info {
            text-align: left;
            margin-top: 20px;
            font-size: 16px;
            color: #555;
        }

        .profile-info .info-item {
            margin-bottom: 10px;
        }

        .info-item i {
            color: #4b7bec;
            margin-right: 10px;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            color: #fff;
            background-color: #4b7bec;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .back-link:hover {
            background-color: #3a5ea7;
        }
    </style>
</head>
<body>

    <div class="profile-card">
        <h1>Admin Profile</h1>
        <p>Welcome, <?php echo $_SESSION['admin_name']; ?>!</p>
        
        <div class="profile-info">
            <div class="info-item"><i class="fas fa-user"></i><strong>Name:</strong> <?php echo $_SESSION['admin_name']; ?></div>
            <!-- Additional profile information can be added here, like email or contact number -->
            <div class="info-item"><i class="fas fa-envelope"></i><strong>Email:</strong> admin@example.com</div>
            <div class="info-item"><i class="fas fa-phone"></i><strong>Contact:</strong> +123 456 7890</div>
        </div>

        <a href="dashboard.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
    </div>

</body>
</html>
