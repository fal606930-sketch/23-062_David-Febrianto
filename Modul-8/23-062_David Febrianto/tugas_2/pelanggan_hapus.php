<?php
include '../tugas_1/cek_login.php';

if ($_SESSION['level'] != 1) {
    header("Location: tugas_2.php");
    exit;
}

include '../tugas_1/koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM pelanggan WHERE id = '$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("Location: pelanggan.php");
        exit;
    } else {
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }
} else {
    header("Location: pelanggan.php");
    exit;
}
?>