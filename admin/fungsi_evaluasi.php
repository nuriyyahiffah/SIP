<?php
function evaluasiKelayakanBarang($kategori, $usia_barang, $jumlah_pemakaian, $harga, $total_barang) {
    if ($usia_barang > 5) {
        return 'Tidak Layak';
    }

    if ($jumlah_pemakaian > 100) {
        return 'Tidak Layak';
    }

    if ($total_barang < 10) {
        return 'Tidak Tersedia';
    }

    if ($harga > 5000000) {
        return 'Perlu Persetujuan Admin';
    }

    if ($kategori == 'Furnitur') {
        if ($jumlah_pemakaian > 50) {
            return 'Tidak Layak';
        } else {
            return 'Layak';
        }
    }

    if ($kategori == 'Elektronik') {
        if ($jumlah_pemakaian > 100) {
            return 'Layak';
        } else {
            return 'Perlu Persetujuan Admin';
        }
    }

    return 'Layak';
}
?>
