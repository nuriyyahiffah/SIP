<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projek_ptc";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update request status if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'], $_POST['action'])) {
    $id = intval($_POST['id']);
    $action = $_POST['action'];

    if ($action == 'approve') {
        $status = 'Approved';
    } elseif ($action == 'reject') {
        $status = 'Rejected';
    }

    $stmt = $conn->prepare("UPDATE peminjaman1 SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    if ($stmt->execute()) {
        echo "Request updated successfully.";
    } else {
        echo "Error updating request: " . $stmt->error;
    }
    $stmt->close();
}

// Retrieve pending borrowing requests
$sql = "SELECT * FROM peminjaman1 WHERE status = 'Pending'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Approval - Borrowing Requests</title>
    <style>
        /* Styling similar to your original code */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f4f4;
            color: #333;
            font-size: 16px;
            line-height: 1.6;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ccc;
        }

        table th {
            background-color: #333;
            color: #fff;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        button {
            padding: 5px 10px;
            font-size: 14px;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .approve {
            background-color: #4CAF50;
        }

        .reject {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <h1>Borrowing Request Approvals</h1>

    <?php
    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <th>Barang</th>
                    <th>Nama Peminjam</th>
                    <th>Keperluan</th>
                    <th>Ruang</th>
                    <th>Mulai Tanggal</th>
                    <th>Sampai Tanggal</th>
                    <th>Mulai Jam</th>
                    <th>Akhir Jam</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['barang']}</td>
                    <td>{$row['nama_peminjam']}</td>
                    <td>{$row['keperluan']}</td>
                    <td>{$row['ruang']}</td>
                    <td>{$row['mulai_tanggal']}</td>
                    <td>{$row['sampai_tanggal']}</td>
                    <td>{$row['mulai_jam']}</td>
                    <td>{$row['akhir_jam']}</td>
                    <td>{$row['status']}</td>
                    <td>
                        <form method='POST' style='display:inline;'>
                            <input type='hidden' name='id' value='{$row['id']}'>
                            <button type='submit' name='action' value='approve' class='approve'>Approve</button>
                            <button type='submit' name='action' value='reject' class='reject'>Reject</button>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='text-align: center;'>No pending borrowing requests found.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
