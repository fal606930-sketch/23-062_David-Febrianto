<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Hapus seluruh session yang berkaitan dengan autentikasi
session_unset();
session_destroy();

// Setelah logout, arahkan user ke halaman login Tugas 1
header("Location: ../tugas_1/tugas_1.php");
exit;
?>