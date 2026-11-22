<?php
include '../tugas_1/cek_login.php';

if ($_SESSION['level'] != 1) {
    header("Location: tugas_2.php");
    exit;
}

include '../tugas_1/koneksi.php';

// Ambil data barang berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "SELECT * FROM barang WHERE id = '$id'");
    $data = mysqli_fetch_array($query);

    if (!$data) {
        header("Location: barang.php");
        exit;
    }
} else if (!isset($_POST['update'])) {
    header("Location: barang.php");
    exit;
}

// Proses update data
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $supplier_id = $_POST['supplier_id'];

    $update_query = "UPDATE barang SET kode_barang='$kode_barang', nama_barang='$nama_barang', harga='$harga', stok='$stok', supplier_id='$supplier_id' WHERE id='$id'";
    $result = mysqli_query($koneksi, $update_query);

    if ($result) {
        header("Location: barang.php");
        exit;
    } else {
        echo "Gagal mengupdate data: " . mysqli_error($koneksi);
    }
}

// Ambil data supplier untuk dropdown
$query_supplier = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data Barang - Modul 8</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; color: #333; }
        .content { padding: 30px; }
        h3 { color: #455a64; font-weight: normal; }
        .form-table { border-collapse: collapse; }
        .form-table td { padding: 8px 10px; vertical-align: middle; font-weight: bold; color: #555; }
        .form-table input[type="text"],
        .form-table input[type="number"],
        .form-table select { padding: 8px; width: 300px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-update { background-color: #7cb342; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; }
        .btn-batal { background-color: #d32f2f; color: white; padding: 7px 15px; text-decoration: none; border-radius: 4px; font-size: 14px; display: inline-block; }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="content">
        <h3>Edit Data Master Barang</h3>

        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

            <table class="form-table">
                <tr>
                    <td>Kode Barang</td>
                    <td><input type="text" name="kode_barang" value="<?php echo htmlspecialchars($data['kode_barang']); ?>" required></td>
                </tr>
                <tr>
                    <td>Nama Barang</td>
                    <td><input type="text" name="nama_barang" value="<?php echo htmlspecialchars($data['nama_barang']); ?>" required></td>
                </tr>
                <tr>
                    <td>Harga</td>
                    <td><input type="number" name="harga" value="<?php echo $data['harga']; ?>" required></td>
                </tr>
                <tr>
                    <td>Stok</td>
                    <td><input type="number" name="stok" value="<?php echo $data['stok']; ?>" required></td>
                </tr>
                <tr>
                    <td>Supplier</td>
                    <td>
                        <select name="supplier_id" required>
                            <option value="">-- Pilih Supplier --</option>
                            <?php while ($s = mysqli_fetch_array($query_supplier)): ?>
                                <option value="<?php echo $s['id']; ?>" <?php echo ($s['id'] == $data['supplier_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($s['nama']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button type="submit" name="update" class="btn-update">Update</button>
                        <a href="barang.php" class="btn-batal">Batal</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>