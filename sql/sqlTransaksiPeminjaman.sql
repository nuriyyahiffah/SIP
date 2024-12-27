CREATE TABLE transaksi_peminjaman (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_barang INT NOT NULL,
    id_peminjaman INT NOT NULL,
    nama_peminjam VARCHAR(50)
    tanggal_pinjam DATE NOT NULL,
    tanggal_kembali DATE NOT NULL,
    status_peminjaman VARCHAR(50) DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
