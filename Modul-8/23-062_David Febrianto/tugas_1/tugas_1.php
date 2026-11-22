<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Pengguna yang sudah login tidak boleh kembali ke halaman login
if (isset($_SESSION['username'])) {
    header("Location: ../tugas_2/tugas_2.php");
    exit;
}

$error = "";

// Proses login
if (isset($_POST['login'])) {
    include 'koneksi.php';

    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $query = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' AND password='$password'");
    $data = mysqli_fetch_array($query);

    if ($data) {
        // Set session identitas dan level user
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['level'] = $data['level']; // Level 1 = Owner, Level 2 = Kasir

        header("Location: ../tugas_2/tugas_2.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Tugas 1 Modul 8</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-box {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 350px;
        }
        .login-box h2 {
            text-align: center;
            color: #1a237e;
            margin-bottom: 25px;
        }
        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .login-box button {
            width: 100%;
            padding: 10px;
            background: #1565c0;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .login-box button:hover {
            background: #1a237e;
        }
        .error {
            color: #d32f2f;
            text-align: center;
            margin-bottom: 15px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Sistem Penjualan</h2>
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="tugas_1.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>