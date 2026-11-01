<?php
include 'koneksi.php';

// Memeriksa apakah ada parameter ID yang dikirim melalui URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Mengambil data supplier berdasarkan ID
    $query = mysqli_query($koneksi, "SELECT * FROM supplier WHERE id = '$id'");
    $data = mysqli_fetch_array($query);
    
    // Jika data tidak ditemukan, kembali ke halaman utama
    if (!$data) {
        header("Location: tugas_3.php");
        exit;
    }
}

// Proses update data ke database jika form disubmit
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $telp = $_POST['telp'];
    $alamat = $_POST['alamat'];

    // Query untuk memperbarui data di tabel supplier
    $update_query = "UPDATE supplier SET nama='$nama', telp='$telp', alamat='$alamat' WHERE id='$id'";
    $result = mysqli_query($koneksi, $update_query);

    if ($result) {
        // Jika berhasil, alihkan kembali ke halaman tugas 3
        header("Location: tugas_3.php");
        exit;
    } else {
        echo "Gagal mengupdate data: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Supplier</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 30px; 
            color: #333;
        }
        h3 { 
            color: #455a64; 
            font-weight: normal;
        }
        .form-table {
            border-collapse: collapse;
        }
        .form-table td {
            padding: 8px 10px;
            vertical-align: middle;
            font-weight: bold;
            color: #555;
        }
        .form-table input[type="text"] {
            padding: 8px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn-update { 
            background-color: #7cb342; 
            color: white; 
            padding: 8px 15px; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer;
            font-size: 14px;
        }
        .btn-batal { 
            background-color: #d32f2f; 
            color: white; 
            padding: 7px 15px; 
            text-decoration: none; 
            border-radius: 4px; 
            font-size: 14px;
            display: inline-block;
        }
    </style>
</head>
<body>

    <h3>Edit Data Master Supplier</h3>

    <form method="POST" action="tugas_5.php">
        <!-- Input hidden untuk menyimpan ID agar bisa dikirim saat submit -->
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
        
        <table class="form-table">
            <tr>
                <td>Nama</td>
                <td><input type="text" name="nama" value="<?php echo htmlspecialchars($data['nama']); ?>" required></td>
            </tr>
            <tr>
                <td>Telp</td>
                <td><input type="text" name="telp" value="<?php echo htmlspecialchars($data['telp']); ?>" required></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td><input type="text" name="alamat" value="<?php echo htmlspecialchars($data['alamat']); ?>" required></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit" name="update" class="btn-update">Update</button>
                    <a href="tugas_3.php" class="btn-batal">Batal</a>
                </td>
            </tr>
        </table>
    </form>

</body>
</html>