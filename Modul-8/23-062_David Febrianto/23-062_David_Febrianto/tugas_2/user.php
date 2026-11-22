<?php
include '../tugas_1/cek_login.php';

if ($_SESSION['level'] != 1) {
    header("Location: tugas_2.php");
    exit;
}

include '../tugas_1/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Master User - Modul 8</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; color: #333; }
        .content { padding: 30px; }
        .header-container { display: flex; justify-content: space-between; align-items: center; }
        h2 { color: #5a8d9a; font-weight: normal; }
        .btn-tambah { background-color: #7cb342; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; font-size: 14px; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #f0f0f0; }
        th { background-color: #e1f5fe; font-weight: bold; }
        .btn-edit { background-color: #e65100; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 13px; margin-right: 5px; }
        .btn-hapus { background-color: #b71c1c; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 13px; }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="content">
        <div class="header-container">
            <h2>Data Master User</h2>
            <a href="user_tambah.php" class="btn-tambah">Tambah Data</a>
        </div>

        <table>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>HP</th>
                <th>Level</th>
                <th>Tindakan</th>
            </tr>
            <?php
            $query = mysqli_query($koneksi, "SELECT * FROM user ORDER BY id_user ASC");
            $no = 1;

            while ($data = mysqli_fetch_array($query)) {
                if ($data['level'] == 1) {
                    $nama_level = 'Owner (Level 1)';
                } elseif ($data['level'] == 2) {
                    $nama_level = 'Kasir (Level 2)';
                } else {
                    $nama_level = 'Level ' . $data['level'];
                }
            ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($data['username']); ?></td>
                    <td><?php echo htmlspecialchars($data['nama']); ?></td>
                    <td><?php echo htmlspecialchars($data['alamat']); ?></td>
                    <td><?php echo htmlspecialchars($data['hp']); ?></td>
                    <td><?php echo $nama_level; ?></td>
                    <td>
                        <a href="user_edit.php?id=<?php echo $data['id_user']; ?>" class="btn-edit">Edit</a>
                        <a href="user_hapus.php?id=<?php echo $data['id_user']; ?>" class="btn-hapus" onclick="return confirm('Anda yakin akan menghapus user ini?')">Hapus</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>
</body>
</html>