CREATE TABLE admin (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nomor_telepon VARCHAR(15),
    jenis_admin ENUM('Admin Pengguna', 'Admin Barang'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
