<?php
$koneksi = mysqli_connect("localhost", "root", "", "db_penjualan");

$mulai = $_GET['mulai'] ?? '';
$selesai = $_GET['selesai'] ?? '';
$is_excel = isset($_GET['excel']) && $_GET['excel'] == '1';

// Cek Jika Mode Export Excel Diaktifkan
if ($is_excel && !empty($mulai) && !empty($selesai)) {
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=Laporan_Penjualan_{$mulai}_sd_{$selesai}.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
}

$labels = [];
$data_total = [];
$rekap = [];
$total_pendapatan = 0;
$total_pelanggan = 0;

if (!empty($mulai) && !empty($selesai)) {
    // 1. Data Agregasi Harian
    $q_harian = "SELECT t.waktu_transaksi AS tgl, SUM(td.harga * td.qty) AS total_harian 
                 FROM transaksi t
                 JOIN transaksi_detail td ON t.id = td.transaksi_id
                 WHERE t.waktu_transaksi BETWEEN '$mulai' AND '$selesai' 
                 GROUP BY t.waktu_transaksi ORDER BY tgl ASC";
    $res_harian = mysqli_query($koneksi, $q_harian);
    
    while ($row = mysqli_fetch_assoc($res_harian)) {
        if (!$is_excel) {
            $labels[] = $row['tgl'];
            $data_total[] = (int)$row['total_harian'];
        }
        $rekap[] = $row;
        $total_pendapatan += $row['total_harian'];
    }

    // 2. Data Pelanggan Unik
    $q_pelanggan = "SELECT COUNT(DISTINCT pelanggan_id) AS jml FROM transaksi WHERE waktu_transaksi BETWEEN '$mulai' AND '$selesai'";
    $total_pelanggan = mysqli_fetch_assoc(mysqli_query($koneksi, $q_pelanggan))['jml'] ?? 0;
}

// -------------------------------------------------------------
// RENDER KHUSUS EXCEL (Jika Tombol Excel Diklik, kode berhenti di sini)
// -------------------------------------------------------------
if ($is_excel): 
?>
    <table border="1">
        <tr>
            <th colspan="3" style="text-align:center;"><b>Rekap Laporan Penjualan <?= $mulai ?> sampai <?= $selesai ?></b></th>
        </tr>
        <tr style="background-color: #dcebf7;">
            <th>No</th><th>Total Pendapatan</th><th>Tanggal Transaksi</th>
        </tr>
        <?php $no = 1; foreach ($rekap as $row): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td>Rp. <?= number_format($row['total_harian'], 0, ',', '.') ?></td>
            <td><?= $row['tgl'] ?></td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="2" style="background-color:#dcebf7; text-align:center;"><b>Jumlah Pelanggan: <?= $total_pelanggan ?> Orang</b></td>
            <td style="background-color:#dcebf7; text-align:center;"><b>Total: Rp. <?= number_format($total_pendapatan, 0, ',', '.') ?></b></td>
        </tr>
    </table>
<?php exit; endif; // Menghentikan rendering HTML biasa ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tugas 3 - Laporan Lengkap</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 10px; text-align: left; }
        th { background-color: #dcebf7; }
        .summary-container { display: flex; gap: 20px; margin-top: 20px; width: 50%; }
        .summary-card { border: 1px solid #000; padding: 15px; flex: 1; background-color: #dcebf7; text-align: center; }
        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body>
    <div class="no-print">
        <h2>Filter Laporan Penjualan</h2>
        <form method="GET">
            Dari: <input type="date" name="mulai" value="<?= htmlspecialchars($mulai) ?>" required>
            Sampai: <input type="date" name="selesai" value="<?= htmlspecialchars($selesai) ?>" required>
            <button type="submit">Tampilkan</button>
        </form>
        <br>
        <button onclick="window.print()">Cetak</button>
        <!-- Tombol Excel memanggil halaman ini sendiri sambil melempar parameter excel=1 -->
        <a href="?mulai=<?= urlencode($mulai) ?>&selesai=<?= urlencode($selesai) ?>&excel=1">
            <button>Excel</button>
        </a>
        <hr>
    </div>

    <?php if (!empty($rekap)): ?>
        <div id="print-area">
            <h3>Rekap Laporan Penjualan <?= htmlspecialchars($mulai) ?> s/d <?= htmlspecialchars($selesai) ?></h3>
            
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
                            label: 'Total Penjualan',
                            data: <?= json_encode($data_total) ?>,
                            backgroundColor: 'rgba(211, 211, 211, 0.8)',
                            borderWidth: 1
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false }
                });
            </script>

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
    <?php endif; ?>
</body>
</html>