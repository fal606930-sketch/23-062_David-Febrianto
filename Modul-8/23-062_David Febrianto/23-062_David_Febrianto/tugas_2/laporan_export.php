<?php
include '../tugas_1/cek_login.php';
include '../tugas_1/koneksi.php';

$mulai = $_GET['mulai'] ?? '';
$selesai = $_GET['selesai'] ?? '';

if (empty($mulai) || empty($selesai)) {
    header("Location: laporan.php");
    exit;
}

// Set HTTP Header untuk download file Excel (Modul 7 Tugas 3)
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Penjualan_{$mulai}_sd_{$selesai}.xls");
header("Pragma: no-cache");
header("Expires: 0");

$rekap = [];
$total_pendapatan = 0;

$q_harian = "SELECT t.waktu_transaksi AS tgl, SUM(td.harga * td.qty) AS total_harian 
             FROM transaksi t
             JOIN transaksi_detail td ON t.id = td.transaksi_id
             WHERE t.waktu_transaksi BETWEEN '$mulai' AND '$selesai' 
             GROUP BY t.waktu_transaksi ORDER BY tgl ASC";
$res_harian = mysqli_query($koneksi, $q_harian);

while ($row = mysqli_fetch_assoc($res_harian)) {
    $rekap[] = $row;
    $total_pendapatan += $row['total_harian'];
}

$q_pelanggan = "SELECT COUNT(DISTINCT pelanggan_id) AS jml FROM transaksi WHERE waktu_transaksi BETWEEN '$mulai' AND '$selesai'";
$total_pelanggan = mysqli_fetch_assoc(mysqli_query($koneksi, $q_pelanggan))['jml'] ?? 0;
?>
<table border="1">
    <tr>
        <th colspan="3" style="text-align:center;"><b>Rekap Laporan Penjualan <?= htmlspecialchars($mulai) ?> sampai <?= htmlspecialchars($selesai) ?></b></th>
    </tr>
    <tr style="background-color: #dcebf7;">
        <th>No</th><th>Total Pendapatan</th><th>Tanggal Transaksi</th>
    </tr>
    <?php $no = 1; foreach ($rekap as $row): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td>Rp. <?= number_format($row['total_harian'], 0, ',', '.') ?></td>
        <td><?= htmlspecialchars($row['tgl']) ?></td>
    </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="2" style="background-color:#dcebf7; text-align:center;"><b>Jumlah Pelanggan: <?= $total_pelanggan ?> Orang</b></td>
        <td style="background-color:#dcebf7; text-align:center;"><b>Total: Rp. <?= number_format($total_pendapatan, 0, ',', '.') ?></b></td>
    </tr>
</table>
<?php
exit;
?>