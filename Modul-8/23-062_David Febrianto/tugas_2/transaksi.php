<?php
include '../tugas_1/cek_login.php';
include '../tugas_1/koneksi.php';

// Sinkronisasi kolom total di tabel master transaksi dengan akumulasi transaksi_detail
mysqli_query($koneksi, "UPDATE transaksi SET total = COALESCE((SELECT SUM(harga * qty) FROM transaksi_detail WHERE transaksi_id = transaksi.id), 0)");

$transaksi_id = isset($_GET['id']) ? $_GET['id'] : null;

// Ambil daftar seluruh transaksi dengan kalkulasi total aktual
$query_list = "SELECT t.id, t.waktu_transaksi, t.keterangan, p.nama AS nama_pelanggan,
               COALESCE((SELECT SUM(harga * qty) FROM transaksi_detail WHERE transaksi_id = t.id), 0) AS total
               FROM transaksi t 
               JOIN pelanggan p ON t.pelanggan_id = p.id 
               ORDER BY t.id ASC";
$result_list = mysqli_query($koneksi, $query_list);

$data_master = null;
$result_detail = null;

if ($transaksi_id) {
    // Ambil data Master
    $query_master = "SELECT t.id, t.waktu_transaksi, t.keterangan, t.pelanggan_id, p.nama AS nama_pelanggan,
                     COALESCE((SELECT SUM(harga * qty) FROM transaksi_detail WHERE transaksi_id = t.id), 0) AS total
                     FROM transaksi t 
                     JOIN pelanggan p ON t.pelanggan_id = p.id 
                     WHERE t.id = $transaksi_id";
    $result_master = mysqli_query($koneksi, $query_master);
    $data_master = mysqli_fetch_assoc($result_master);

    // Ambil data Detail transaksi
    $query_detail = "SELECT td.*, b.nama_barang, b.kode_barang 
                     FROM transaksi_detail td 
                     JOIN barang b ON td.barang_id = b.id 
                     WHERE td.transaksi_id = $transaksi_id";
    $result_detail = mysqli_query($koneksi, $query_detail);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Transaksi - Modul 8</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; color: #333; }
        .content { padding: 30px; }
        h2 { color: #5a8d9a; font-weight: normal; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #e1f5fe; font-weight: bold; }
        .master-info { background: #e9ecef; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 5px solid #28a745; }
        .btn-lihat { background-color: #1565c0; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 13px; }
        .btn-tambah { background-color: #28a745; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; font-size: 14px; display: inline-block; margin-bottom: 15px; }
        .btn-hapus { background-color: #b71c1c; color: white; padding: 4px 8px; text-decoration: none; border-radius: 4px; font-size: 12px; }
        .btn-hapus:hover { background-color: #c82333; }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="content">

        <h2>Daftar Transaksi</h2>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Keterangan</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                while ($t = mysqli_fetch_assoc($result_list)): 
                ?>
                <tr <?php echo ($transaksi_id == $t['id']) ? 'style="background:#e1f5fe;"' : ''; ?>>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $t['id']; ?></td>
                    <td><?php echo $t['waktu_transaksi']; ?></td>
                    <td><?php echo htmlspecialchars($t['nama_pelanggan']); ?></td>
                    <td><?php echo htmlspecialchars($t['keterangan']); ?></td>
                    <td>Rp <?php echo number_format($t['total'], 0, ',', '.'); ?></td>
                    <td><a href="transaksi.php?id=<?php echo $t['id']; ?>" class="btn-lihat">Lihat Detail</a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <?php if ($data_master): ?>
            <hr>
            <h2>Detail Transaksi #<?php echo $data_master['id']; ?></h2>

            <div class="master-info">
                <p><strong>ID Transaksi:</strong> <?php echo $data_master['id']; ?></p>
                <p><strong>Pelanggan:</strong> <?php echo htmlspecialchars($data_master['nama_pelanggan']); ?> (<?php echo $data_master['pelanggan_id']; ?>)</p>
                <p><strong>Waktu Transaksi:</strong> <?php echo $data_master['waktu_transaksi']; ?></p>
                <p><strong>Keterangan:</strong> <?php echo htmlspecialchars($data_master['keterangan']); ?></p>
                <h3 style="color: #d32f2f; margin: 5px 0;">Total: Rp <?php echo number_format($data_master['total'], 0, ',', '.'); ?></h3>
            </div>

            <a href="transaksi_tambah.php?id=<?php echo $data_master['id']; ?>" class="btn-tambah">+ Tambah Barang ke Transaksi</a>

            <table>
                <thead>
                    <tr>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Harga Satuan</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th style="text-align:center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $cek_baris = mysqli_num_rows($result_detail);
                    $grand_total = 0;
                    if ($cek_baris > 0) {
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
                        <td style="text-align:center;">
                            <a href="transaksi_hapus.php?transaksi_id=<?php echo $transaksi_id; ?>&barang_id=<?php echo $row['barang_id']; ?>" 
                               class="btn-hapus" 
                               onclick="return confirm('Apakah Anda yakin ingin menghapus <?php echo htmlspecialchars($row['nama_barang']); ?> dari transaksi ini?');">Hapus</a>
                        </td>
                    </tr>
                    <?php 
                        endwhile; 
                    } else {
                        echo "<tr><td colspan='6' style='text-align:center;'>Belum ada barang di transaksi ini.</td></tr>";
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr style="background-color: #f4f4f4;">
                        <th colspan="4" style="text-align:right">Total Transaksi:</th>
                        <th colspan="2">Rp <?php echo number_format($grand_total, 0, ',', '.'); ?></th>
                    </tr>
                </tfoot>
            </table>
        <?php endif; ?>

    </div>
</body>
</html>