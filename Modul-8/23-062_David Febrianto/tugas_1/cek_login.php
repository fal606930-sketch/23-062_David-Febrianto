<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jika user belum login, arahkan ke halaman login tugas_1.php
if (!isset($_SESSION['username'])) {
    header("Location: ../tugas_1/tugas_1.php");
    exit;
}
?>