<?php
include '../tugas_1/cek_login.php';
include '../tugas_1/koneksi.php';

$mulai = $_GET['mulai'] ?? '';
$selesai = $_GET['selesai'] ?? '';

$labels = [];
$data_total = [];

if (!empty($mulai) && !empty($selesai)) {
    // Agregasi pendapatan harian untuk grafik (Modul 7 Tugas 2)
    $q_harian = "SELECT t.waktu_transaksi AS tgl, SUM(td.harga * td.qty) AS total_harian 
                 FROM transaksi t
                 JOIN transaksi_detail td ON t.id = td.transaksi_id
                 WHERE t.waktu_transaksi BETWEEN '$mulai' AND '$selesai' 
                 GROUP BY t.waktu_transaksi 
                 ORDER BY tgl ASC";
    $res_harian = mysqli_query($koneksi, $q_harian);
    
    while ($row = mysqli_fetch_assoc($res_harian)) {
        $labels[] = $row['tgl'];
        $data_total[] = (int)$row['total_harian'];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Grafik Penjualan - Modul 8</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; color: #333; }
        .content { padding: 30px; }
        h2 { color: #5a8d9a; font-weight: normal; }
        .btn-action { background-color: #1565c0; color: white; border: none; padding: 8px 15px; cursor: pointer; border-radius: 4px; text-decoration: none; display: inline-block; font-size: 13px; margin-right: 5px; }
        .btn-action:hover { background-color: #1a237e; }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="content">
        <h2>Grafik Penjualan Harian</h2>
        <form method="GET" action="laporan_grafik.php">
            Dari: <input type="date" name="mulai" value="<?= htmlspecialchars($mulai) ?>" required>
            Sampai: <input type="date" name="selesai" value="<?= htmlspecialchars($selesai) ?>" required>
            <button type="submit" class="btn-action">Tampilkan</button>
            <?php if (!empty($mulai) && !empty($selesai)): ?>
                <a href="laporan.php?mulai=<?= urlencode($mulai) ?>&selesai=<?= urlencode($selesai) ?>" class="btn-action">Lihat Tabel Laporan</a>
            <?php endif; ?>
        </form>
        <hr>

        <?php if (!empty($labels)): ?>
            <h3>Visualisasi Pendapatan Harian (<?= htmlspecialchars($mulai) ?> s/d <?= htmlspecialchars($selesai) ?>)</h3>
            <div style="width: 80%; height: 400px; margin-top: 20px;">
                <canvas id="myChart"></canvas>
            </div>
            <script>
                const ctx = document.getElementById('myChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?= json_encode($labels) ?>,
                        datasets: [{
                            label: 'Total Pendapatan (Rp)',
                            data: <?= json_encode($data_total) ?>,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false }
                });
            </script>
        <?php elseif (!empty($mulai) && !empty($selesai)): ?>
            <p>Tidak ada data penjualan pada rentang tanggal tersebut.</p>
        <?php endif; ?>
    </div>
</body>
</html>