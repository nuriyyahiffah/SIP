<?php
$conn = new mysqli('localhost', 'root', '', 'projek_ptc');

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

var_dump($_POST);
die();


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];  
    $barang = $_POST['barang'];  
    $nama_peminjam = $_POST['nama_peminjam'];
    $keperluan = $_POST['keperluan'];
    $ruang = $_POST['ruang'];
    $mulai_tanggal = $_POST['mulai_tanggal'];
    $sampai_tanggal = $_POST['sampai_tanggal'];
    $mulai_jam = $_POST['mulai_jam'];
    $akhir_jam = $_POST['akhir_jam'];
    $status = 'Dipinjam';

    $query_peminjaman1 = "INSERT INTO peminjaman11 (id, barang, nama_peminjam, keperluan, ruang, mulai_tanggal, sampai_tanggal, mulai_jam, akhir_jam, status) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    if ($stmt_peminjaman1 = $conn->prepare($query_peminjaman1)) {
        $stmt_peminjaman1->bind_param("isssssssss", $id, $barang, $nama_peminjam, $keperluan, $ruang, $mulai_tanggal, $sampai_tanggal, $mulai_jam, $akhir_jam, $status);
        $stmt_peminjaman1->execute();
        if ($stmt_peminjaman1->affected_rows <= 0) {
            echo "Gagal memasukkan data ke peminjaman1.";
        }
    } else {
        echo "Error preparing query untuk peminjaman1: " . $conn->error;
    }

    $query_peminjaman2 = "INSERT INTO peminjaman22 (id, barang, nama_peminjam, keperluan, ruang, mulai_tanggal, sampai_tanggal, mulai_jam, akhir_jam, status) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    if ($stmt_peminjaman2 = $conn->prepare($query_peminjaman2)) {
        $stmt_peminjaman2->bind_param("isssssssss", $id, $barang, $nama_peminjam, $keperluan, $ruang, $mulai_tanggal, $sampai_tanggal, $mulai_jam, $akhir_jam, $status);
        $stmt_peminjaman2->execute();
        if ($stmt_peminjaman2->affected_rows <= 0) {
            echo "Gagal memasukkan data ke peminjaman2.";
        }
    } else {
        echo "Error preparing query untuk peminjaman2: " . $conn->error;
    }

    $query_transaksi = "INSERT INTO transaksi_peminjaman (id, barang, nama_peminjam, tanggal_pinjam, tanggal_kembali, keperluan, ruang, mulai_tanggal, sampai_tanggal, status_peminjaman, created_at)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    if ($stmt_transaksi = $conn->prepare($query_transaksi)) {
        $stmt_transaksi->bind_param("issssssssss", $id, $barang, $nama_peminjam, $mulai_tanggal, $sampai_tanggal, $keperluan, $ruang, $mulai_tanggal, $sampai_tanggal, $status);
        $stmt_transaksi->execute();
        if ($stmt_transaksi->affected_rows > 0) {
            echo "Data peminjaman berhasil dimasukkan ke transaksi_peminjaman.";
        } else {
            echo "Gagal memasukkan data ke transaksi_peminjaman.";
        }
    } else {
        echo "Error preparing query untuk transaksi_peminjaman: " . $conn->error;
    }

    $stmt_peminjaman1->close();
    $stmt_peminjaman2->close();
    $stmt_transaksi->close();
    $conn->close();
}
?>
