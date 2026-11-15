<?php
$koneksi = mysqli_connect("localhost", "root", "", "db_penjualan");
$mulai = $_GET['mulai'] ?? '';
$selesai = $_GET['selesai'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tugas 1 - Filter Laporan Penjualan</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 10px; text-align: left; }
        th { background-color: #dcebf7; }
    </style>
</head>
<body>
    <h2>Filter Laporan Penjualan</h2>
    <form method="GET">
        Dari: <input type="date" name="mulai" value="<?= htmlspecialchars($mulai) ?>" required>
        Sampai: <input type="date" name="selesai" value="<?= htmlspecialchars($selesai) ?>" required>
        <button type="submit">Tampilkan</button>
    </form>
    <hr>

    <?php if (!empty($mulai) && !empty($selesai)): ?>
        <h3>Data Transaksi (<?= htmlspecialchars($mulai) ?> s/d <?= htmlspecialchars($selesai) ?>)</h3>
        <table>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Total Transaksi</th>
            </tr>
            <?php
            // Mengambil data transaksi dan mengkalkulasi total dari transaksi_detail
            $query = "SELECT t.waktu_transaksi, t.keterangan, SUM(td.harga * td.qty) AS total 
                      FROM transaksi t
                      JOIN transaksi_detail td ON t.id = td.transaksi_id
                      WHERE t.waktu_transaksi BETWEEN '$mulai' AND '$selesai'
                      GROUP BY t.id ORDER BY t.waktu_transaksi ASC";
            $result = mysqli_query($koneksi, $query);
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)):
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['waktu_transaksi']) ?></td>
                <td><?= htmlspecialchars($row['keterangan']) ?></td>
                <td>Rp. <?= number_format($row['total'], 0, ',', '.') ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>
</body>
</html>