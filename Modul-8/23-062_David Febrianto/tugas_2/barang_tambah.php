<?php
include '../tugas_1/cek_login.php';

if ($_SESSION['level'] != 1) {
    header("Location: tugas_2.php");
    exit;
}

include '../tugas_1/koneksi.php';

// Proses simpan data ke database
if (isset($_POST['simpan'])) {
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $supplier_id = $_POST['supplier_id'];

    $query = "INSERT INTO barang (kode_barang, nama_barang, harga, stok, supplier_id) VALUES ('$kode_barang', '$nama_barang', '$harga', '$stok', '$supplier_id')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("Location: barang.php");
        exit;
    } else {
        echo "Gagal menambah data: " . mysqli_error($koneksi);
    }
}

// Ambil data supplier untuk dropdown
$query_supplier = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Barang - Modul 8</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; color: #333; }
        .content { padding: 30px; }
        h3 { color: #455a64; font-weight: normal; }
        .form-table { border-collapse: collapse; }
        .form-table td { padding: 8px 10px; vertical-align: middle; font-weight: bold; color: #555; }
        .form-table input[type="text"],
        .form-table input[type="number"],
        .form-table select { padding: 8px; width: 300px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-simpan { background-color: #7cb342; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; }
        .btn-batal { background-color: #d32f2f; color: white; padding: 7px 15px; text-decoration: none; border-radius: 4px; font-size: 14px; display: inline-block; }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="content">
        <h3>Tambah Data Master Barang Baru</h3>

        <form method="POST" action="barang_tambah.php">
            <table class="form-table">
                <tr>
                    <td>Kode Barang</td>
                    <td><input type="text" name="kode_barang" placeholder="Kode Barang" required></td>
                </tr>
                <tr>
                    <td>Nama Barang</td>
                    <td><input type="text" name="nama_barang" placeholder="Nama Barang" required></td>
                </tr>
                <tr>
                    <td>Harga</td>
                    <td><input type="number" name="harga" placeholder="Harga" required></td>
                </tr>
                <tr>
                    <td>Stok</td>
                    <td><input type="number" name="stok" placeholder="Stok" required></td>
                </tr>
                <tr>
                    <td>Supplier</td>
                    <td>
                        <select name="supplier_id" required>
                            <option value="">-- Pilih Supplier --</option>
                            <?php while ($s = mysqli_fetch_array($query_supplier)): ?>
                                <option value="<?php echo $s['id']; ?>"><?php echo htmlspecialchars($s['nama']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button type="submit" name="simpan" class="btn-simpan">Simpan</button>
                        <a href="barang.php" class="btn-batal">Batal</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>