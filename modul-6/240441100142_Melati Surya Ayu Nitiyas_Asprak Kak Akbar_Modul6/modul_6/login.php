<?php
session_start();
include("koneksi.php");

$message = "";
$mode = $_GET['mode'] ?? 'login'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    
    if ($mode === 'login') {
        $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
        if (mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $_SESSION['login'] = true;
                $_SESSION['username'] = $user['username'];
                header("Location: dashboard.php");
                exit;
            } else {
                $message = "Password salah.";
            }
        } else {
            $message = "Username tidak ditemukan.";
        }

    
    } elseif ($mode === 'register') {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $check = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
        if (mysqli_num_rows($check) > 0) {
            $message = "Username sudah digunakan.";
        } else {
            $insert = mysqli_query($conn, "INSERT INTO users (username, password) VALUES ('$username', '$password_hash')");
            if ($insert) {
                $message = "Registrasi berhasil. <a href='?mode=login' class='text-decoration-underline'>Login di sini</a>";
            } else {
                $message = "Registrasi gagal: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title><?= $mode === 'login' ? 'Login' : 'Daftar' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
        <h2 class="card-title text-center mb-4"><?= $mode === 'login' ? 'Login Pengguna' : 'Daftar Pengguna' ?></h2>

        <?php if ($message): ?>
            <div class="alert <?= strpos($message, 'berhasil') !== false ? 'alert-success' : 'alert-danger' ?>" role="alert">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form method="post" class="mb-3" novalidate>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" required
                       class="form-control" value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '' ?>" />
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" required class="form-control" />
            </div>
            <button type="submit"
                    class="btn w-100 <?= $mode === 'login' ? 'btn-primary' : 'btn-success' ?>">
                <?= $mode === 'login' ? 'Login' : 'Daftar' ?>
            </button>
        </form>

        <p class="text-center small text-muted">
            <?php if ($mode === 'login'): ?>
                Belum punya akun? <a href="?mode=register" class="text-decoration-underline">Daftar</a>
            <?php else: ?>
                Sudah punya akun? <a href="?mode=login" class="text-decoration-underline">Login</a>
            <?php endif; ?>
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
