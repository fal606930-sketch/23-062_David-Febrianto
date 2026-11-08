<?php
// tugas_4.php
// Pastikan koneksi database sesuai dengan pengaturan di komputermu
$koneksi = mysqli_connect("localhost", "root", "", "db_penjualan");

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// ========================================================
// PROSES INPUT DETAIL & AUTO-UPDATE TOTAL (TUGAS 4)
// ========================================================
if (isset($_POST['tambah_detail'])) {
    $id_transaksi_post = $_POST['transaksi_id'];
    $barang_id = $_POST['barang_id'];
    $qty = $_POST['qty'];

    // 1. Ambil harga barang saat ini dari tabel barang
    $query_harga = mysqli_query($koneksi, "SELECT harga FROM barang WHERE id = $barang_id");
    $data_harga = mysqli_fetch_assoc($query_harga);
    $harga_satuan = $data_harga['harga'];

    // 2. Insert data baru ke tabel transaksi_detail
    $query_insert = "INSERT INTO transaksi_detail (transaksi_id, barang_id, harga, qty) 
                     VALUES ($id_transaksi_post, $barang_id, $harga_satuan, $qty)";
    
    if (mysqli_query($koneksi, $query_insert)) {
        // 3. Hitung ulang total transaksi (SUM(harga * qty)) dari seluruh detail transaksi ini
        $query_sum = "SELECT SUM(harga * qty) AS total_baru 
                      FROM transaksi_detail 
                      WHERE transaksi_id = $id_transaksi_post";
        $result_sum = mysqli_query($koneksi, $query_sum);
        $data_sum = mysqli_fetch_assoc($result_sum);
        
        // Atasi nilai null jika misal tidak ada data (meski secara logika pasti ada karena baru di-insert)
        $total_baru = $data_sum['total_baru'] ? $data_sum['total_baru'] : 0; 

        // 4. Update kolom total di tabel transaksi master
        $query_update_total = "UPDATE transaksi SET total = $total_baru WHERE id = $id_transaksi_post";
        mysqli_query($koneksi, $query_update_total);

        // Berikan notifikasi sukses dan refresh halaman
        echo "<script>
                alert('Berhasil! Detail transaksi ditambahkan.\\nTotal Transaksi otomatis diperbarui menjadi Rp " . number_format($total_baru, 0, ',', '.') . "');
                window.location.href='tugas_4.php?id=$id_transaksi_post';
              </script>";
    } else {
        echo "<script>alert('Gagal menambahkan detail transaksi!');</script>";
    }
}

// ========================================================
// MENAMPILKAN DATA (SAMA SEPERTI TUGAS 2)
// ========================================================
$transaksi_id = isset($_GET['id']) ? $_GET['id'] : 1;

// Ambil data Master
$query_master = "SELECT t.*, p.nama AS nama_pelanggan FROM transaksi t 
                 JOIN pelanggan p ON t.pelanggan_id = p.id WHERE t.id = $transaksi_id";
$result_master = mysqli_query($koneksi, $query_master);
$data_master = mysqli_fetch_assoc($result_master);

// Ambil data Detail
$query_detail = "SELECT td.*, b.nama_barang, b.kode_barang FROM transaksi_detail td 
                 JOIN barang b ON td.barang_id = b.id WHERE td.transaksi_id = $transaksi_id";
$result_detail = mysqli_query($koneksi, $query_detail);

// Ambil data Barang (Filter NOT IN agar tidak dobel input)
$query_barang = "SELECT * FROM barang WHERE id NOT IN (
                    SELECT barang_id FROM transaksi_detail WHERE transaksi_id = $transaksi_id
                 )";
$result_barang = mysqli_query($koneksi, $query_barang);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Auto Update Total Transaksi (Tugas 4)</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .master-info { background: #e9ecef; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 5px solid #28a745; }
        .form-tambah { background: #f8f9fa; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        button { background-color: #28a745; color: white; border: none; padding: 8px 15px; cursor: pointer; border-radius: 4px; }
        button:hover { background-color: #218838; }
    </style>
</head>
<body>

    <h2>Demo Master-Detail & Auto Update Total</h2>

    <?php if ($data_master): ?>
        <div class="master-info">
            <p><strong>ID Transaksi:</strong> <?php echo $data_master['id']; ?></p>
            <p><strong>Pelanggan:</strong> <?php echo $data_master['nama_pelanggan']; ?></p>
            <!-- Di sinilah nilai total master ditampilkan, ini akan berubah setiap kali form di bawah di-submit -->
            <h3 style="color: #d32f2f; margin: 5px 0;">Total di Database Master: Rp <?php echo number_format($data_master['total'], 0, ',', '.'); ?></h3>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga Satuan</th>
                    <th>Qty</th>
                    <th>Subtotal (Detail)</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $cek_baris = mysqli_num_rows($result_detail);
                if ($cek_baris > 0) {
                    while($row = mysqli_fetch_assoc($result_detail)): 
                        $subtotal = $row['harga'] * $row['qty'];
                ?>
                <tr>
                    <td><?php echo $row['kode_barang']; ?></td>
                    <td><?php echo $row['nama_barang']; ?></td>
                    <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td><?php echo $row['qty']; ?></td>
                    <td>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                </tr>
                <?php 
                    endwhile; 
                } else {
                    echo "<tr><td colspan='5' style='text-align:center;'>Belum ada barang di transaksi ini.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="form-tambah">
            <h3>Tambah Item Baru</h3>
            <form action="" method="POST">
                <input type="hidden" name="transaksi_id" value="<?php echo $transaksi_id; ?>">
                
                <label>Pilih Barang:</label>
                <select name="barang_id" required>
                    <option value="">-- Pilih Barang --</option>
                    <?php while($b = mysqli_fetch_assoc($result_barang)): ?>
                        <option value="<?php echo $b['id']; ?>">
                            <?php echo $b['nama_barang'] . " (Rp " . number_format($b['harga'], 0, ',', '.') . ")"; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                
                <label style="margin-left: 10px;">Qty:</label>
                <input type="number" name="qty" min="1" required style="width: 60px;">
                
                <button type="submit" name="tambah_detail" style="margin-left: 10px;">Simpan Detail & Update Total</button>
            </form>
        </div>

    <?php else: ?>
        <p>Data transaksi master tidak ditemukan.</p>
    <?php endif; ?>

</body>
</html>