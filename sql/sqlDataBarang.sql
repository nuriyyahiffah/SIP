CREATE TABLE data_barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(255),  -- Menambahkan kode_barang sebagai pengidentifikasi barang
    nama_barang VARCHAR(255),
    jumlah INT,                 -- Menambahkan jumlah untuk jumlah barang
    usia_barang INT,            -- Menambahkan usia_barang jika diperlukan
    status_barang VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Menambahkan kolom created_at dengan nilai default timestamp
    deskripsi TEXT,             -- Menambahkan deskripsi untuk penjelasan lebih lanjut mengenai barang
    nama_peminjam VARCHAR(255),
    keperluan TEXT,
    ruang VARCHAR(255),
    mulai_tanggal DATE,
    sampai_tanggal DATE,
    mulai_jam TIME,
    akhir_jam TIME,
    status VARCHAR(50)
);
