<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projek_ptc";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['table'])) {
    $id_peminjaman = $_POST['id'];
    $table = $_POST['table'];
    $keterangan_pengembalian = isset($_POST['pengembalian']) ? $_POST['pengembalian'] : ''; 

    $allowed_tables = ['peminjaman1', 'peminjaman2'];
    if (in_array($table, $allowed_tables)) {
        $sql = "SELECT * FROM $table WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_peminjaman);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $tanggal_pengembalian = date('Y-m-d');

            $foto_path = null;
            if (isset($_FILES['foto_pengembalian']) && $_FILES['foto_pengembalian']['error'] == 0) {
                $target_dir = "uploads/";
                if (!is_dir($target_dir)) {
                    mkdir($target_dir, 0755, true);
                }

                $file_extension = strtolower(pathinfo($_FILES["foto_pengembalian"]["name"], PATHINFO_EXTENSION));
                $unique_name = uniqid("foto_", true) . "." . $file_extension;
                $target_file = $target_dir . $unique_name;

                $uploadOk = 1;

                if (getimagesize($_FILES["foto_pengembalian"]["tmp_name"]) === false) {
                    echo "File yang diupload bukan gambar.";
                    $uploadOk = 0;
                }

                if ($_FILES["foto_pengembalian"]["size"] > 5000000) {
                    echo "File terlalu besar.";
                    $uploadOk = 0;
                }

                if (!in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                    echo "Hanya file gambar JPG, JPEG, PNG & GIF yang diperbolehkan.";
                    $uploadOk = 0;
                }

                if ($uploadOk == 1) {
                    if (move_uploaded_file($_FILES["foto_pengembalian"]["tmp_name"], $target_file)) {
                        $foto_path = $target_file;
                    } else {
                        echo "Terjadi kesalahan saat mengupload file.";
                        exit;
                    }
                } else {
                    echo "Upload file gagal.";
                    exit;
                }
            }

            $sql_update = "UPDATE $table SET status = 'Dikembalikan', tanggal_pengembalian = ?, pengembalian = ?, foto_pengembalian = ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("sssi", $tanggal_pengembalian, $keterangan_pengembalian, $foto_path, $id_peminjaman);

            if ($stmt_update->execute()) {
                echo "<script>
                        alert('Barang berhasil dikembalikan.');
                        window.location.href = 'barang_yang_dipinjam.php';
                      </script>";
            } else {
                echo "Error saat memperbarui data: " . $stmt_update->error;
            }

            $stmt_update->close();
        } else {
            echo "Data peminjaman tidak ditemukan.";
            exit;
        }

        $stmt->close();
    } else {
        echo "Tabel tidak valid.";
        exit;
    }
} else {
    echo "Data tidak lengkap. Berikut data POST yang diterima:";
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
    exit;
}

$conn->close();
?>
