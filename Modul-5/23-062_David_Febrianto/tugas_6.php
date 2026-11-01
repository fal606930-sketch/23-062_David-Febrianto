<?php
include 'koneksi.php';

// Memeriksa apakah ada parameter ID yang dikirim melalui URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data dari tabel supplier berdasarkan ID
    $query = "DELETE FROM supplier WHERE id = '$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        // Jika berhasil dihapus, alihkan kembali ke halaman tugas 3
        header("Location: tugas_3.php");
        exit;
    } else {
        // Menampilkan pesan error jika data sedang digunakan di tabel lain (Foreign Key constraint)
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }
} else {
    // Jika tidak ada ID yang dikirim, kembalikan ke halaman utama
    header("Location: tugas_3.php");
    exit;
}
?>