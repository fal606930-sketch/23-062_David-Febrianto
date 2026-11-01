<?php
$host = "localhost";
$user = "root"; // Username default XAMPP/Laragon/MAMP
$pass = "";     // Kosongkan jika menggunakan pengaturan default
$db   = "tugas_praktikum"; // Nama database yang dibuat pada Tugas 1

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>