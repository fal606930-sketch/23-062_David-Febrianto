<?php
include '../tugas_1/cek_login.php';
include '../tugas_1/koneksi.php';

// Validasi parameter transaksi_id dan barang_id
if (isset($_GET['transaksi_id']) && isset($_GET['barang_id'])) {
    $id_transaksi = $_GET['transaksi_id'];
    $barang_id = $_GET['barang_id'];

    // Hapus baris barang dari transaksi_detail
    $query_delete = "DELETE FROM transaksi_detail WHERE transaksi_id = $id_transaksi AND barang_id = $barang_id";
    if (mysqli_query($koneksi, $query_delete)) {
        // Hitung ulang total transaksi setelah item dihapus
        $query_sum = "SELECT SUM(harga * qty) AS total_baru 
                      FROM transaksi_detail 
                      WHERE transaksi_id = $id_transaksi";
        $result_sum = mysqli_query($koneksi, $query_sum);
        $data_sum = mysqli_fetch_assoc($result_sum);
        $total_baru = $data_sum['total_baru'] ? $data_sum['total_baru'] : 0; 

        // Update kolom total di tabel transaksi master
        $query_update_total = "UPDATE transaksi SET total = $total_baru WHERE id = $id_transaksi";
        mysqli_query($koneksi, $query_update_total);

        echo "<script>
                alert('Berhasil! Item dihapus.\\nTotal Transaksi otomatis diperbarui menjadi Rp " . number_format($total_baru, 0, ',', '.') . "');
                window.location.href='transaksi.php?id=$id_transaksi';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Gagal menghapus detail transaksi!');
                window.location.href='transaksi.php?id=$id_transaksi';
              </script>";
        exit;
    }
} else {
    header("Location: transaksi.php");
    exit;
}
?>