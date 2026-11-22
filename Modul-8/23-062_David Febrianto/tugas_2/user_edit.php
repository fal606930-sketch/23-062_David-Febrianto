<?php
include '../tugas_1/cek_login.php';

if ($_SESSION['level'] != 1) {
    header("Location: tugas_2.php");
    exit;
}

include '../tugas_1/koneksi.php';

// Ambil data user berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE id_user = '$id'");
    $data = mysqli_fetch_array($query);

    if (!$data) {
        header("Location: user.php");
        exit;
    }
} else if (!isset($_POST['update'])) {
    header("Location: user.php");
    exit;
}

// Proses update data
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $hp = $_POST['hp'];
    $level = $_POST['level'];

    // Jika password diisi, update password dengan MD5 hash
    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']);
        $update_query = "UPDATE user SET username='$username', password='$password', nama='$nama', alamat='$alamat', hp='$hp', level='$level' WHERE id_user='$id'";
    } else {
        // Jika password kosong, pertahankan password yang lama
        $update_query = "UPDATE user SET username='$username', nama='$nama', alamat='$alamat', hp='$hp', level='$level' WHERE id_user='$id'";
    }

    $result = mysqli_query($koneksi, $update_query);

    if ($result) {
        header("Location: user.php");
        exit;
    } else {
        echo "Gagal mengupdate data: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data User - Modul 8</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; color: #333; }
        .content { padding: 30px; }
        h3 { color: #455a64; font-weight: normal; }
        .form-table { border-collapse: collapse; }
        .form-table td { padding: 8px 10px; vertical-align: middle; font-weight: bold; color: #555; }
        .form-table input[type="text"],
        .form-table input[type="password"],
        .form-table select { padding: 8px; width: 300px; border: 1px solid #ccc; border-radius: 4px; }
        .btn-update { background-color: #7cb342; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; }
        .btn-batal { background-color: #d32f2f; color: white; padding: 7px 15px; text-decoration: none; border-radius: 4px; font-size: 14px; display: inline-block; }
        .hint { font-weight: normal; font-size: 12px; color: #888; }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="content">
        <h3>Edit Data Master User</h3>

        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo $data['id_user']; ?>">

            <table class="form-table">
                <tr>
                    <td>Username</td>
                    <td><input type="text" name="username" value="<?php echo htmlspecialchars($data['username']); ?>" required></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak diubah">
                        <br><span class="hint">Kosongkan jika tidak ingin mengubah password</span>
                    </td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td><input type="text" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td><input type="text" name="alamat" value="<?php echo htmlspecialchars($data['alamat']); ?>" required></td>
                </tr>
                <tr>
                    <td>HP</td>
                    <td><input type="text" name="hp" value="<?php echo htmlspecialchars($data['hp']); ?>" required></td>
                </tr>
                <tr>
                    <td>Level</td>
                    <td>
                        <select name="level" required>
                            <option value="1" <?php echo ($data['level'] == 1) ? 'selected' : ''; ?>>Owner (Level 1)</option>
                            <option value="2" <?php echo ($data['level'] == 2) ? 'selected' : ''; ?>>Kasir (Level 2)</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button type="submit" name="update" class="btn-update">Update</button>
                        <a href="user.php" class="btn-batal">Batal</a>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>