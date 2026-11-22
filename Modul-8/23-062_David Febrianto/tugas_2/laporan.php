<?php
include '../tugas_1/cek_login.php';
include '../tugas_1/koneksi.php';

$mulai = $_GET['mulai'] ?? '';
$selesai = $_GET['selesai'] ?? '';

$labels = [];
$data_total = [];
$rekap = [];
$total_pendapatan = 0;
$total_pelanggan = 0;

if (!empty($mulai) && !empty($selesai)) {
    // 1. Data Agregasi Harian (Modul 7)
    $q_harian = "SELECT t.waktu_transaksi AS tgl, SUM(td.harga * td.qty) AS total_harian 
                 FROM transaksi t
                 JOIN transaksi_detail td ON t.id = td.transaksi_id
                 WHERE t.waktu_transaksi BETWEEN '$mulai' AND '$selesai' 
                 GROUP BY t.waktu_transaksi ORDER BY tgl ASC";
    $res_harian = mysqli_query($koneksi, $q_harian);
    
    while ($row = mysqli_fetch_assoc($res_harian)) {
        $labels[] = $row['tgl'];
        $data_total[] = (int)$row['total_harian'];
        $rekap[] = $row;
        $total_pendapatan += $row['total_harian'];
    }

    // 2. Data Pelanggan Unik (Modul 7)
    $q_pelanggan = "SELECT COUNT(DISTINCT pelanggan_id) AS jml FROM transaksi WHERE waktu_transaksi BETWEEN '$mulai' AND '$selesai'";
    $total_pelanggan = mysqli_fetch_assoc(mysqli_query($koneksi, $q_pelanggan))['jml'] ?? 0;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan - Modul 8</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; color: #333; }
        .content { padding: 30px; }
        h2 { color: #5a8d9a; font-weight: normal; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 10px; text-align: left; }
        th { background-color: #dcebf7; }
        .summary-container { display: flex; gap: 20px; margin-top: 20px; width: 50%; }
        .summary-card { border: 1px solid #000; padding: 15px; flex: 1; background-color: #dcebf7; text-align: center; }
        .btn-action { background-color: #1565c0; color: white; border: none; padding: 8px 15px; cursor: pointer; border-radius: 4px; text-decoration: none; display: inline-block; font-size: 13px; margin-right: 5px; }
        .btn-action:hover { background-color: #1a237e; }
        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="content">
        <div class="no-print">
            <h2>Filter Laporan Penjualan</h2>
            <form method="GET" action="laporan.php">
                Dari: <input type="date" name="mulai" value="<?= htmlspecialchars($mulai) ?>" required>
                Sampai: <input type="date" name="selesai" value="<?= htmlspecialchars($selesai) ?>" required>
                <button type="submit" class="btn-action">Tampilkan</button>
            </form>
            <br>
            <?php if (!empty($rekap)): ?>
                <button onclick="window.print()" class="btn-action">Cetak</button>
                <a href="laporan_export.php?mulai=<?= urlencode($mulai) ?>&selesai=<?= urlencode($selesai) ?>" class="btn-action">Export Excel</a>
            <?php endif; ?>
            <hr>
        </div>

        <?php if (!empty($rekap)): ?>
            <div id="print-area">
                <h3>Rekap Laporan Penjualan (<?= htmlspecialchars($mulai) ?> s/d <?= htmlspecialchars($selesai) ?>)</h3>

                <!-- Tampilan Grafik Penjualan (Modul 7) -->
                <div style="width: 80%; height: 400px; margin-bottom: 30px;">
                    <canvas id="myChart"></canvas>
                </div>
                <script>
                    const ctx = document.getElementById('myChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: <?= json_encode($labels) ?>,
                            datasets: [{
                                label: 'Total Penjualan (Rp)',
                                data: <?= json_encode($data_total) ?>,
                                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: { responsive: true, maintainAspectRatio: false }
                    });
                </script>

                <!-- Tabel Laporan Penjualan -->
                <table>
                    <thead>
                        <tr><th>No</th><th>Total Pendapatan</th><th>Tanggal Transaksi</th></tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($rekap as $row): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>Rp. <?= number_format($row['total_harian'], 0, ',', '.') ?></td>
                            <td><?= htmlspecialchars($row['tgl']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <!-- Summary Cards -->
                <div class="summary-container">
                    <div class="summary-card">
                        <p>Jumlah Pelanggan</p>
                        <h3><?= $total_pelanggan ?> Orang</h3>
                    </div>
                    <div class="summary-card">
                        <p>Jumlah Pendapatan</p>
                        <h3>Rp. <?= number_format($total_pendapatan, 0, ',', '.') ?></h3>
                    </div>
                </div>
            </div>
        <?php elseif (!empty($mulai) && !empty($selesai)): ?>
            <p>Tidak ada transaksi pada rentang tanggal tersebut.</p>
        <?php endif; ?>
    </div>
</body>
</html>