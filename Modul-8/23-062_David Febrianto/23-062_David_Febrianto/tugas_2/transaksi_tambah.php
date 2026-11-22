<?php
include '../tugas_1/cek_login.php';
include '../tugas_1/koneksi.php';

// Memeriksa parameter ID transaksi
if (!isset($_GET['id']) && !isset($_POST['transaksi_id'])) {
    header("Location: transaksi.php");
    exit;
}

$transaksi_id = isset($_POST['transaksi_id']) ? $_POST['transaksi_id'] : $_GET['id'];

// ========================================================
// PROSES INPUT DETAIL & AUTO-UPDATE TOTAL (MODUL 6 TUGAS 4)
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
        // 3. Hitung ulang total transaksi (SUM(harga * qty))
        $query_sum = "SELECT SUM(harga * qty) AS total_baru 
                      FROM transaksi_detail 
                      WHERE transaksi_id = $id_transaksi_post";
        $result_sum = mysqli_query($koneksi, $query_sum);
        $data_sum = mysqli_fetch_assoc($result_sum);
        $total_baru = $data_sum['total_baru'] ? $data_sum['total_baru'] : 0; 

        // 4. Update kolom total di tabel transaksi master
        $query_update_total = "UPDATE transaksi SET total = $total_baru WHERE id = $id_transaksi_post";
        mysqli_query($koneksi, $query_update_total);

        echo "<script>
                alert('Berhasil! Detail transaksi ditambahkan.\\nTotal Transaksi otomatis diperbarui menjadi Rp " . number_format($total_baru, 0, ',', '.') . "');
                window.location.href='transaksi.php?id=$id_transaksi_post';
              </script>";
        exit;
    } else {
        echo "<script>alert('Gagal menambahkan detail transaksi!');</script>";
    }
}

// Ambil data transaksi master
$query_master = mysqli_query($koneksi, "SELECT t.*, p.nama AS nama_pelanggan FROM transaksi t JOIN pelanggan p ON t.pelanggan_id = p.id WHERE t.id = $transaksi_id");
$data_master = mysqli_fetch_assoc($query_master);

if (!$data_master) {
    header("Location: transaksi.php");
    exit;
}

// Ambil data Barang (Filter NOT IN agar barang yang sudah dipilih tidak muncul lagi)
$query_barang = "SELECT * FROM barang WHERE id NOT IN (
                    SELECT barang_id FROM transaksi_detail WHERE transaksi_id = $transaksi_id
                 )";
$result_barang = mysqli_query($koneksi, $query_barang);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Barang ke Transaksi - Modul 8</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; color: #333; }
        .content { padding: 30px; }
        h2 { color: #5a8d9a; font-weight: normal; }
        .form-tambah { background: #f8f9fa; padding: 20px; border: 1px solid #ddd; border-radius: 5px; max-width: 500px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group select, .form-group input { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-simpan { background-color: #28a745; color: white; border: none; padding: 10px 18px; cursor: pointer; border-radius: 4px; font-size: 14px; }
        .btn-simpan:hover { background-color: #218838; }
        .btn-batal { background-color: #d32f2f; color: white; padding: 9px 15px; text-decoration: none; border-radius: 4px; font-size: 14px; display: inline-block; }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="content">
        <h2>Tambah Barang ke Transaksi #<?php echo $transaksi_id; ?></h2>
        <p>Pelanggan: <strong><?php echo htmlspecialchars($data_master['nama_pelanggan']); ?></strong></p>

        <div class="form-tambah">
            <form action="transaksi_tambah.php" method="POST">
                <input type="hidden" name="transaksi_id" value="<?php echo $transaksi_id; ?>">
                
                <div class="form-group">
                    <label for="barang_id">Pilih Barang:</label>
                    <select name="barang_id" id="barang_id" required>
                        <option value="">-- Pilih Barang --</option>
                        <?php while($b = mysqli_fetch_assoc($result_barang)): ?>
                            <option value="<?php echo $b['id']; ?>">
                                <?php echo htmlspecialchars($b['nama_barang']) . " (Rp " . number_format($b['harga'], 0, ',', '.') . ")"; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="qty">Jumlah (Qty):</label>
                    <input type="number" name="qty" id="qty" min="1" required placeholder="Masukkan jumlah barang">
                </div>
                
                <button type="submit" name="tambah_detail" class="btn-simpan">Simpan Detail & Update Total</button>
                <a href="transaksi.php?id=<?php echo $transaksi_id; ?>" class="btn-batal">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>