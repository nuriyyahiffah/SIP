<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About SIP - Sistem Peminjaman Barang Kampus ITH</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Header Styling */
        header {
            background-color: #004080;
            color: white;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        header .logo {
            display: flex;
            align-items: center;
        }

        header .logo img {
            height: 50px;
            margin-right: 10px;
        }

        header h1 {
            font-size: 1.5em;
        }

        .auth-links a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
            font-weight: bold;
        }

        nav ul {
            display: flex;
            list-style-type: none;
        }

        nav ul li {
            position: relative;
            margin-left: 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 15px;
            display: inline-block;
            background-color: #006400; /* Dark green background for main buttons */
            border-radius: 5px;
        }

        /* Dropdown Menu */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #004d00; /* Darker green for dropdown items */
            min-width: 150px;
            box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 5px;
        }

        .dropdown-content a {
            color: #b3ffb3; /* Light green for dropdown text */
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            border-radius: 5px;
        }

        .dropdown-content a:hover {
            background-color: #008000; /* Hover effect for dropdown items */
            color: white;
        }

        /* Show dropdown on hover */
        nav ul li:hover .dropdown-content {
            display: block;
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
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li>
                    <a href="#">About Us</a>
                    <div class="dropdown-content">
                        <a href="campus1.php">Kampus 1</a>
                        <a href="campus2.php">Kampus 2</a>
                    </div>
                </li>
                <li><a href="profil_user.php">Profil</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </nav>
    </header>

</body>
</html>
