<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="card shadow-lg p-4 rounded-4" style="max-width: 400px; width: 100%;">
        <h2 class="mb-4 text-center text-primary">
            Selamat datang, <span class="fw-bold"><?= htmlspecialchars($_SESSION['username']); ?></span>!
        </h2>
        <div class="d-grid gap-3 mt-4">
            <a href="absen.php" class="btn btn-success btn-lg">Input Data Karyawan &amp; Absensi</a>
            <a href="data.php" class="btn btn-primary btn-lg">Lihat Data Karyawan</a>
            <a href="login.php" class="btn btn-danger btn-lg">Logout</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
