<?php
function getPeminjamanData($conn) {
    $sql = "
        SELECT p.id, p.nama_peminjam, d.NAMABARANG, d.status_kelayakan, p.keperluan, p.ruang, p.mulai_tanggal, p.sampai_tanggal, p.status, p.created_at
        FROM peminjaman1 p
        LEFT JOIN daftarbarang d ON p.kode_barang = d.KODEBARANG
        UNION
        SELECT p2.id, p2.nama_peminjam, d2.NAMABARANG, d2.status_kelayakan, p2.keperluan, p2.ruang, p2.mulai_tanggal, p2.sampai_tanggal, p2.status, p2.created_at
        FROM peminjaman2 p2
        LEFT JOIN daftarbarang d2 ON p2.kode_barang = d2.KODEBARANG
        ORDER BY created_at DESC
    ";

    return $conn->query($sql);
}
?>
