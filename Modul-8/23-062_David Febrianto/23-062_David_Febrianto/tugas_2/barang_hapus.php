<?php
include '../tugas_1/cek_login.php';

if ($_SESSION['level'] != 1) {
    header("Location: tugas_2.php");
    exit;
}

include '../tugas_1/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Cek apakah barang ini dipakai di tabel transaksi_detail (sesuai Modul 6 tugas_3.php)
    $query_cek = "SELECT COUNT(*) as jumlah_pakai FROM transaksi_detail WHERE barang_id = $id";
    $result_cek = mysqli_query($koneksi, $query_cek);
    $row_cek = mysqli_fetch_assoc($result_cek);

    // 2. Logika Validasi Hapus
    if ($row_cek['jumlah_pakai'] > 0) {
        echo "<script>
                alert('GAGAL MENGHAPUS! Barang ini tidak boleh dihapus karena masih digunakan pada " . $row_cek['jumlah_pakai'] . " data transaksi detail.');
                window.location.href = 'barang.php';
              </script>";
    } else {
        $query = "DELETE FROM barang WHERE id = '$id'";
        $result = mysqli_query($koneksi, $query);

        if ($result) {
            header("Location: barang.php");
            exit;
        } else {
            echo "Gagal menghapus data: " . mysqli_error($koneksi);
        }
    }
} else {
    header("Location: barang.php");
    exit;
}
?>