<?php
// tugas_2.php
// Sesuaikan username 'root' dan password '' dengan pengaturan MySQL kamu
$koneksi = mysqli_connect("localhost", "root", "", "db_penjualan");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Simulasi mengambil ID transaksi dari URL (contoh: tugas_2.php?id=1)
// Jika tidak ada ID di URL, set default ke transaksi ID = 1
$transaksi_id = isset($_GET['id']) ? $_GET['id'] : 1;

// 1. AMBIL DATA MASTER (TRANSAKSI)
$query_master = "SELECT t.*, p.nama AS nama_pelanggan 
                 FROM transaksi t 
                 JOIN pelanggan p ON t.pelanggan_id = p.id 
                 WHERE t.id = $transaksi_id";
$result_master = mysqli_query($koneksi, $query_master);
$data_master = mysqli_fetch_assoc($result_master);

// 2. AMBIL DATA DETAIL (TRANSAKSI_DETAIL)
$query_detail = "SELECT td.*, b.nama_barang, b.kode_barang 
                 FROM transaksi_detail td 
                 JOIN barang b ON td.barang_id = b.id 
                 WHERE td.transaksi_id = $transaksi_id";
$result_detail = mysqli_query($koneksi, $query_detail);

// 3. AMBIL DATA BARANG UNTUK DROPDOWN (Pengecekan Barang yang Belum Dipilih)
// Memfilter barang agar yang sudah ada di transaksi_detail tidak muncul lagi di dropdown
$query_barang = "SELECT * FROM barang 
                 WHERE id NOT IN (
                    SELECT barang_id FROM transaksi_detail WHERE transaksi_id = $transaksi_id
                 )";
$result_barang = mysqli_query($koneksi, $query_barang);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Master-Detail Transaksi</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        .master-info { background: #e9ecef; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
    </style>
</head>
<body>

    <h2>Data Transaksi (Master)</h2>
    
    <?php if ($data_master): ?>
        <div class="master-info">
            <p><strong>ID Transaksi:</strong> <?php echo $data_master['id']; ?></p>
            <p><strong>Waktu Transaksi:</strong> <?php echo $data_master['waktu_transaksi']; ?></p>
            <p><strong>Pelanggan:</strong> <?php echo $data_master['nama_pelanggan']; ?> (<?php echo $data_master['pelanggan_id']; ?>)</p>
            <p><strong>Keterangan:</strong> <?php echo $data_master['keterangan']; ?></p>
            <p><strong>Total:</strong> Rp <?php echo number_format($data_master['total'], 0, ',', '.'); ?></p>
        </div>

        <h2>Item Transaksi (Detail)</h2>
        <table>
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga Satuan</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $grand_total = 0;
                while($row = mysqli_fetch_assoc($result_detail)): 
                    $subtotal = $row['harga'] * $row['qty'];
                    $grand_total += $subtotal;
                ?>
                <tr>
                    <td><?php echo $row['kode_barang']; ?></td>
                    <td><?php echo $row['nama_barang']; ?></td>
                    <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td><?php echo $row['qty']; ?></td>
                    <td>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" style="text-align:right">Total Transaksi Aktual</th>
                    <th>Rp <?php echo number_format($grand_total, 0, ',', '.'); ?></th>
                </tr>
            </tfoot>
        </table>

        <h2>Tambah Barang ke Transaksi</h2>
        <!-- Form ini biasanya akan di-post ke file proses, misalnya ke tugas_4.php untuk sekalian auto-update total -->
        <form action="" method="POST">
            <input type="hidden" name="transaksi_id" value="<?php echo $transaksi_id; ?>">
            
            <label for="barang_id">Pilih Barang:</label>
            <select name="barang_id" id="barang_id" required>
                <option value="">-- Pilih Barang --</option>
                <?php while($b = mysqli_fetch_assoc($result_barang)): ?>
                    <option value="<?php echo $b['id']; ?>">
                        <?php echo $b['nama_barang'] . " (Rp " . number_format($b['harga'], 0, ',', '.') . ")"; ?>
                    </option>
                <?php endwhile; ?>
            </select>
            
            <label for="qty">Jumlah (Qty):</label>
            <input type="number" name="qty" id="qty" min="1" required style="width: 60px;">
            
            <button type="submit" name="tambah_detail">Tambah Item</button>
        </form>

    <?php else: ?>
        <p>Data transaksi tidak ditemukan.</p>
    <?php endif; ?>

</body>
</html>