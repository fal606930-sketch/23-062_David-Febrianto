<?php
// tugas_3.php
// Sesuaikan dengan konfigurasi database kamu
$koneksi = mysqli_connect("localhost", "root", "", "db_penjualan");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// ========================================================
// PROSES HAPUS DATA BARANG
// ========================================================
if (isset($_GET['hapus_id'])) {
    $barang_id = $_GET['hapus_id'];

    // 1. Cek apakah barang ini dipakai di tabel transaksi_detail
    $query_cek = "SELECT COUNT(*) as jumlah_pakai FROM transaksi_detail WHERE barang_id = $barang_id";
    $result_cek = mysqli_query($koneksi, $query_cek);
    $row_cek = mysqli_fetch_assoc($result_cek);

    // 2. Logika Validasi Hapus
    if ($row_cek['jumlah_pakai'] > 0) {
        // Jika sudah dipakai, tampilkan notifikasi penolakan
        echo "<script>
                alert('GAGAL MENGHAPUS! Barang ini tidak boleh dihapus karena masih digunakan pada " . $row_cek['jumlah_pakai'] . " data transaksi detail.');
                window.location.href = 'tugas_3.php';
              </script>";
    } else {
        // Jika belum dipakai, proses penghapusan seperti biasa
        $query_hapus = "DELETE FROM barang WHERE id = $barang_id";
        if (mysqli_query($koneksi, $query_hapus)) {
            echo "<script>
                    alert('BERHASIL! Data barang berhasil dihapus dari sistem.');
                    window.location.href = 'tugas_3.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Terjadi kesalahan saat menghapus data.');
                    window.location.href = 'tugas_3.php';
                  </script>";
        }
    }
}

// Ambil semua data barang untuk ditampilkan di tabel
$query_barang = "SELECT b.*, s.nama as nama_supplier 
                 FROM barang b 
                 LEFT JOIN supplier s ON b.supplier_id = s.id";
$result_barang = mysqli_query($koneksi, $query_barang);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Fitur Hapus Barang (Tugas 3)</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .btn-hapus { 
            background-color: #dc3545; 
            color: white; 
            padding: 6px 12px; 
            text-decoration: none; 
            border-radius: 4px; 
            font-size: 14px;
        }
        .btn-hapus:hover { background-color: #c82333; }
        .info-box { background: #e9ecef; padding: 15px; border-left: 5px solid #17a2b8; }
    </style>
</head>
<body>
    <h2>Data Master Barang</h2>
    <div class="info-box">
        <strong>Tugas 3:</strong> Menguji Fitur Hapus Data. <br>
        Sistem akan mengecek ketersediaan data di tabel <code>transaksi_detail</code> sebelum menghapus data di tabel <code>barang</code>.
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Supplier</th>
                <th style="text-align:center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = mysqli_fetch_assoc($result_barang)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['kode_barang']; ?></td>
                <td><?php echo $row['nama_barang']; ?></td>
                <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                <td><?php echo $row['stok']; ?></td>
                <td><?php echo $row['nama_supplier']; ?></td>
                <td style="text-align:center;">
                    <!-- Tombol hapus akan memanggil file ini sendiri dengan menyertakan parameter URL hapus_id -->
                    <a href="tugas_3.php?hapus_id=<?php echo $row['id']; ?>" class="btn-hapus" onclick="return confirm('Apakah kamu yakin ingin menghapus <?php echo $row['nama_barang']; ?>?');">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>