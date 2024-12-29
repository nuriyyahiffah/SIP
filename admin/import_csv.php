<?php
include '../db_connection.php';

if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

$csvFilePath = "daftarbarang.csv";

if (!file_exists($csvFilePath)) {
    die("File CSV tidak ditemukan: $csvFilePath");
}

$csvFile = fopen($csvFilePath, "r");
if ($csvFile === false) {
    die("Gagal membuka file CSV.");
}

fgetcsv($csvFile);

while (($data = fgetcsv($csvFile, 1000, ",")) !== FALSE) {
    $NO = $data[0];
    $KODEBARANG = $data[1];
    $NAMABARANG = $data[2];
    $USIABARANG = $data[3];
    $TAHUNMASUK = $data[4];
    $JUMLAHPEMAKAIAN = $data[5];
    $HARGA = $data[6];
    $TOTALBARANG = $data[7];
    $KATEGORI = $data[8];
    $status_kelayakan = $data[9];

    $sql = "INSERT INTO daftarbarangg (NO, KODEBARANG, NAMABARANG, USIABARANG, TAHUNMASUK, JUMLAHPEMAKAIAN, HARGA, TOTALBARANG, KATEGORI, status_kelayakan) 
            VALUES ('$NO', '$KODEBARANG', '$NAMABARANG', '$USIABARANG', '$TAHUNMASUK', '$JUMLAHPEMAKAIAN', '$HARGA', '$TOTALBARANG', '$KATEGORI', '$status_kelayakan')";

    if ($conn->query($sql) === TRUE) {
        echo "Data berhasil diimpor untuk barang: $NAMABARANG<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

fclose($csvFile);

$conn->close();

echo "Impor data selesai!";
?>
