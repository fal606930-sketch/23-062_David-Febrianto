<?php
$koneksi = mysqli_connect("localhost", "root", "", "db_penjualan");
$mulai = $_GET['mulai'] ?? '';
$selesai = $_GET['selesai'] ?? '';

$labels = [];
$data_total = [];

if (!empty($mulai) && !empty($selesai)) {
    // Agregasi pendapatan harian
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
    <title>Tugas 2 - Grafik Penjualan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style> body { font-family: Arial, sans-serif; padding: 20px; } </style>
</head>
<body>
    <h2>Filter Laporan Penjualan</h2>
    <form method="GET">
        Dari: <input type="date" name="mulai" value="<?= htmlspecialchars($mulai) ?>" required>
        Sampai: <input type="date" name="selesai" value="<?= htmlspecialchars($selesai) ?>" required>
        <button type="submit">Tampilkan</button>
    </form>
    <hr>

    <?php if (!empty($labels)): ?>
        <h3>Grafik Penjualan Harian</h3>
        <div style="width: 80%; height: 400px;">
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
    <?php elseif (isset($_GET['mulai'])): ?>
        <p>Tidak ada data.</p>
    <?php endif; ?>
</body>
</html>