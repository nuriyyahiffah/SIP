<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About SIP - Sistem Peminjaman Barang Kampus ITH</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        background-color:rgb(236, 236, 236); /* Ivory */
        line-height: 1.6;
        font-size: 16px;
    }

    header {
        background-color: #000000; /* Midnight Blue */
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

    nav ul {
        display: flex;
        list-style: none;
    }

    nav ul li {
        margin-left: 10px;
    }

    nav ul li a {
        color: whitesmoke;
        background-color:rgb(0, 0, 0); /* Dusty Blue */
        text-decoration: none;
        font-weight: bold;
        padding: 10px 15px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    nav ul li a:hover {
        background-color: #1C2E4A; /* Midnight Blue - hover */
    }

    main {
        flex: 1;
        padding: 40px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .hero {
        background:rgb(236, 236, 236); /* Dusty Blue */
        height: 60vh;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
        width: 100%;
    }

    .hero h2 {
        font-size: 2.5em;
        font-weight: bold;
        color: #1C2E4A; /* Midnight Blue */
    }

    .summary-section {
        display: flex;
        justify-content: space-between;
        gap: 30px;
        margin-top: 30px;
        width: 100%;
        max-width: 1200px;
        padding: 0 20px;
    }

    .card {
        background-color:rgb(0, 0, 0); /* Midnight Blue */
        color: white;
        border-radius: 38px;
        padding: 15px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        width: 30%; /* Adjust card width */
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    .card h3 {
        font-size: 1.7em;
        color: #BDC4D4; /* Ivory */
    }

    .card p {
        font-size: 15px;
        margin-bottom: 10px;
    }

    .card a {
        display: inline-block;
        padding: 10px 13px;
        background-color: #BDC4D4; /* Ivory */
        color: #1C2E4A; /* Midnight Blue */
        text-decoration: none;
        border-radius: 22px;
        font-weight: bold;
        transition: background-color 0.3s ease;
        margin-top: auto;
    }

    .card a:hover {
        background-color: #52677D; /* Dusty Blue */
        color: white;
    }

    footer {
        background-color:rgb(0, 0, 0); /* Midnight Blue */
        color: white;
        text-align: center;
        padding: 15px 0;
        margin-top: 23px;
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
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </nav>
</header>

<main>
    <div class="hero">
        <h2>Selamat Datang di Sistem Peminjaman Barang Kampus ITH</h2>
    </div>

    <div class="summary-section">
        <!-- Card Kampus 1 (left-aligned) -->
        <div class="card">
            <h3>Barang di Kampus 1</h3>
            <p>Daftar barang yang tersedia di Kampus 1.</p>
            <a href="kampus1.php">Lihat Barang</a>
        </div>

        <!-- Card Kampus 2 (right-aligned) -->
        <div class="card">
            <h3>Barang di Kampus 2</h3>
            <p>Daftar barang yang tersedia di Kampus 2.</p>
            <a href="kampus2.php">Lihat Barang</a>
        </div>
    </div>
</main>

<footer>
    <p>&copy; 2024 SIP - Sistem Peminjaman Barang Kampus ITH. All Rights Reserved.</p>
</footer>

</body>
</html>
