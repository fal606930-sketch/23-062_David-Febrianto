<?php
// Memanggil file koneksi
include 'koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Master Supplier</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 30px; 
            color: #333;
        }
        .header-container { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            width: 80%; 
        }
        h2 { 
            color: #5a8d9a; 
            font-weight: normal;
        }
        .btn-tambah { 
            background-color: #7cb342; 
            color: white; 
            padding: 8px 15px; 
            text-decoration: none; 
            border-radius: 4px; 
            font-size: 14px;
        }
        table { 
            border-collapse: collapse; 
            width: 80%; 
            margin-top: 10px; 
        }
        th, td { 
            padding: 10px; 
            text-align: left; 
            border-bottom: 1px solid #f0f0f0; 
        }
        th { 
            background-color: #e1f5fe; 
            font-weight: bold;
        }
        .btn-edit { 
            background-color: #e65100; 
            color: white; 
            padding: 5px 10px; 
            text-decoration: none; 
            border-radius: 4px; 
            font-size: 13px;
            margin-right: 5px;
        }
        .btn-hapus { 
            background-color: #b71c1c; 
            color: white; 
            padding: 5px 10px; 
            text-decoration: none; 
            border-radius: 4px; 
            font-size: 13px;
        }
    </style>
</head>
<body>

    <div class="header-container">
        <h2>Data Master Supplier</h2>
        <!-- Mengarah ke file tugas_4.php untuk tambah data -->
        <a href="tugas_4.php" class="btn-tambah">Tambah Data</a>
    </div>

    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Telp</th>
            <th>Alamat</th>
            <th>Tindakan</th>
        </tr>
        <?php
        // Mengambil data dari database
        $query = mysqli_query($koneksi, "SELECT * FROM supplier ORDER BY id ASC");
        $no = 1;
        
        while ($data = mysqli_fetch_array($query)) {
        ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($data['nama']); ?></td>
                <td><?php echo htmlspecialchars($data['telp']); ?></td>
                <td><?php echo htmlspecialchars($data['alamat']); ?></td>
                <td>
                    <!-- Mengarah ke file tugas_5.php untuk edit data -->
                    <a href="tugas_5.php?id=<?php echo $data['id']; ?>" class="btn-edit">Edit</a>
                    <!-- Mengarah ke file tugas_6.php dengan popup konfirmasi hapus dari localhost -->
                    <a href="tugas_6.php?id=<?php echo $data['id']; ?>" class="btn-hapus" onclick="return confirm('Anda yakin akan menghapus supplier ini?')">Hapus</a>
                </td>
            </tr>
        <?php 
        }
        ?>
    </table>

</body>
</html>