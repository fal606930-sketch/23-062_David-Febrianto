<style>
    .navbar {
        background: linear-gradient(to right, #1a237e, #1565c0);
        padding: 0;
        margin: 0;
        display: flex;
        align-items: center;
        font-family: Arial, sans-serif;
    }
    .navbar a, .navbar .brand {
        color: white;
        text-decoration: none;
        padding: 14px 18px;
        display: inline-block;
        font-size: 14px;
    }
    .navbar .brand {
        font-weight: bold;
        background: rgba(0,0,0,0.15);
        font-size: 15px;
    }
    .navbar a:hover {
        background: rgba(255,255,255,0.1);
    }
    .navbar .dropdown {
        position: relative;
        display: inline-block;
    }
    .navbar .dropdown-content {
        display: none;
        position: absolute;
        background: #1565c0;
        min-width: 180px;
        z-index: 1000;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    .navbar .dropdown-content a {
        display: block;
        padding: 10px 18px;
    }
    .navbar .dropdown-content a:hover {
        background: #1a237e;
    }
    .navbar .dropdown:hover .dropdown-content {
        display: block;
    }
    .navbar .right {
        margin-left: auto;
        display: flex;
        align-items: center;
    }
    .navbar .user-info {
        color: white;
        padding: 14px 10px;
        font-size: 14px;
    }
    .navbar .logout-btn {
        background: rgba(255,255,255,0.15);
        border-radius: 4px;
        margin-right: 10px;
        padding: 8px 15px !important;
    }
</style>

<div class="navbar">
    <span class="brand">&#9632; Sistem Penjualan</span>
    <a href="tugas_2.php">Home</a>

    <?php if (isset($_SESSION['level']) && $_SESSION['level'] == 1): ?>
    <!-- Menu Khusus Owner (Level 1) -->
    <div class="dropdown">
        <a href="#">Data Master &#9660;</a>
        <div class="dropdown-content">
            <a href="barang.php">Data Barang</a>
            <a href="supplier.php">Data Supplier</a>
            <a href="pelanggan.php">Data Pelanggan</a>
            <a href="user.php">Data User</a>
        </div>
    </div>
    <?php endif; ?>

    <!-- Menu untuk Owner dan Kasir -->
    <a href="transaksi.php">Transaksi</a>
    <a href="laporan.php">Laporan</a>

    <div class="right">
        <span class="user-info"><?php echo htmlspecialchars($_SESSION['nama'] ?? 'User'); ?></span>
        <a href="../tugas_3/tugas_3.php" class="logout-btn">Logout</a>
    </div>
</div>