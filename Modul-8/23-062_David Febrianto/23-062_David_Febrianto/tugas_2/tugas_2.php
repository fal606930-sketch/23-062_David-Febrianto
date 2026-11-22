<?php
include '../tugas_1/cek_login.php';
include '../tugas_1/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Home - Tugas 2 Modul 8</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; color: #333; }
        .content { padding: 30px; }
        h2 { color: #5a8d9a; font-weight: normal; }
        .welcome-box {
            background: #e1f5fe;
            padding: 20px;
            border-radius: 5px;
            border-left: 5px solid #1565c0;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="content">
        <h2>Selamat Datang, <?php echo htmlspecialchars($_SESSION['nama']); ?></h2>
        <div class="welcome-box">
            <p>Anda login sebagai: <strong><?php echo ($_SESSION['level'] == 1) ? 'Owner (Level 1)' : 'Kasir (Level 2)'; ?></strong></p>
            <p>Silakan gunakan menu navigasi di atas untuk mengakses fitur yang tersedia sesuai hak akses Anda.</p>
        </div>
    </div>
</body>
</html>