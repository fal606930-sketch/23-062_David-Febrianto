<?php
include '../tugas_1/cek_login.php';

if ($_SESSION['level'] != 1) {
    header("Location: tugas_2.php");
    exit;
}

include '../tugas_1/koneksi.php';

// Proses simpan data ke database
if (isset($_POST['simpan'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    $query = "INSERT INTO pelanggan (id, nama, jenis_kelamin, telp, alamat) VALUES ('$id', '$nama', '$jenis_kelamin', '$telp', '$alamat')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        header("Location: pelanggan.php");
        exit;
    } else {
        echo "Gagal menambah data: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Pelanggan - Modul 8</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; color: #333; }
        .content { padding: 30px; }
        h3 { color: #455a64; font-weight: normal; }
        .form-table { border-collapse: collapse; }
        .form-table td { padding: 8px 10px; vertical-align: middle; font-weight: bold; color: #555; }
        .form-table input[type="text"],
        .form-table select { padding: 8px; width: 300px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-simpan { background-color: #7cb342; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; }
        .btn-batal { background-color: #d32f2f; color: white; padding: 7px 15px; text-decoration: none; border-radius: 4px; font-size: 14px; display: inline-block; }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="content">
        <h3>Tambah Data Master Pelanggan Baru</h3>

        <form method="POST" action="pelanggan_tambah.php">
            <table class="form-table">
                <tr>
                    <td>ID Pelanggan</td>
                    <td><input type="text" name="id" placeholder="Contoh: PEL006" required></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td><input type="text" name="nama" placeholder="Nama" required></td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>
                        <select name="jenis_kelamin" required>
                            <option value="">-- Pilih --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Telp</td>
                    <td><input type="text" name="telp" placeholder="Telp" required></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td><input type="text" name="alamat" placeholder="Alamat" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button type="submit" name="simpan" class="btn-simpan">Simpan</button>
                        <a href="pelanggan.php" class="btn-batal">Batal</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>