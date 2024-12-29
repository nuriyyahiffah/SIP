<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Menerima data dari form
    $kodeBarang = $_POST['kodeBarang'];
    $namaBarang = $_POST['namaBarang'];
    $kondisi = $_POST['kondisi'];
    $tanggalJam = $_POST['tanggalJam'];

    // Proses upload file
    $fotoBarang = '';
    if (isset($_FILES['fotoBarang']) && $_FILES['fotoBarang']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/'; // Folder tempat file diunggah
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileName = basename($_FILES['fotoBarang']['name']);
        $targetFile = $uploadDir . $fileName;

        // Validasi dan pindahkan file
        if (move_uploaded_file($_FILES['fotoBarang']['tmp_name'], $targetFile)) {
            $fotoBarang = $targetFile;
        } else {
            echo "<p>Gagal mengunggah file.</p>";
        }
    }

    // Simpan ke database (contoh koneksi dan query sederhana)
    $conn = new mysqli('localhost', 'root', '', 'projek_ptc');

    if ($conn->connect_error) {
        die("Koneksi database gagal: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO pengembalian (kode_barang, nama_barang, kondisi, tanggal_jam_pengembalian, foto_barang) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $kodeBarang, $namaBarang, $kondisi, $tanggalJam, $fotoBarang);

    if ($stmt->execute()) {
        echo "<p>Pengembalian barang berhasil disimpan.</p>";
    } else {
        echo "<p>Terjadi kesalahan: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<p>Form belum diisi.</p>";
}
?>