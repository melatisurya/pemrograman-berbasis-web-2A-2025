<?php
session_start();
include("koneksi.php");
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// Hapus data
if (isset($_GET['hapus'])) {
    $id = (int)$_GET['hapus'];
    mysqli_query($conn, "DELETE FROM karyawan_absensi WHERE id = $id");
    header("Location: data.php");
    exit;
}

// Ambil data edit
$editData = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM karyawan_absensi WHERE id = $id");
    $editData = mysqli_fetch_assoc($result);
}

// Update data
if (isset($_POST['update'])) {
    $id = (int)$_POST['id'];
    $nip = mysqli_real_escape_string($conn, $_POST['nip']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $umur = (int)$_POST['umur'];
    $jk = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $departemen = mysqli_real_escape_string($conn, $_POST['departemen']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $kota = mysqli_real_escape_string($conn, $_POST['kota_asal']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal_absensi']);
    $masuk = mysqli_real_escape_string($conn, $_POST['jam_masuk']);
    $pulang = mysqli_real_escape_string($conn, $_POST['jam_pulang']);

    $sql = "UPDATE karyawan_absensi SET 
            nip='$nip', 
            nama='$nama', 
            umur=$umur, 
            jenis_kelamin='$jk', 
            departemen='$departemen', 
            jabatan='$jabatan', 
            kota_asal='$kota', 
            tanggal_absensi='$tanggal', 
            jam_masuk='$masuk', 
            jam_pulang='$pulang' 
            WHERE id = $id";
    mysqli_query($conn, $sql);
    header("Location: data.php");
    exit;
}

$data = mysqli_query($conn, "SELECT * FROM karyawan_absensi");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Data Karyawan & Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light text-dark">

<div class="container my-5">
    <h2 class="mb-4">Data Karyawan & Absensi</h2>

    <div class="d-flex justify-content-between mb-3">
        <a href="absen.php" class="btn btn-success">Tambah Data</a>
        <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light text-uppercase">
                <tr>
                    <th>NIP</th>
                    <th>Nama</th>
                    <th>Umur</th>
                    <th>JK</th>
                    <th>Departemen</th>
                    <th>Jabatan</th>
                    <th>Kota</th>
                    <th>Tanggal</th>
                    <th>Masuk</th>
                    <th>Pulang</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['nip']) ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['umur']) ?></td>
                        <td><?= htmlspecialchars($row['jenis_kelamin']) ?></td>
                        <td><?= htmlspecialchars($row['departemen']) ?></td>
                        <td><?= htmlspecialchars($row['jabatan']) ?></td>
                        <td><?= htmlspecialchars($row['kota_asal']) ?></td>
                        <td><?= htmlspecialchars($row['tanggal_absensi']) ?></td>
                        <td><?= htmlspecialchars($row['jam_masuk']) ?></td>
                        <td><?= htmlspecialchars($row['jam_pulang']) ?></td>
                        <td>
                            <a href="?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm me-1">Edit</a>
                            <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus data?')" class="btn btn-danger btn-sm">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if ($editData): ?>
<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Edit Data Karyawan & Absensi</h5>
        </div>
        <div class="card-body">
            <form method="post" class="row g-3">
                <input type="hidden" name="id" value="<?= htmlspecialchars($editData['id']) ?>">

                <div class="col-md-6">
                    <label for="nip" class="form-label">NIP</label>
                    <input type="text" name="nip" id="nip" value="<?= htmlspecialchars($editData['nip']) ?>" required class="form-control" placeholder="NIP">
                </div>
                <div class="col-md-6">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" id="nama" value="<?= htmlspecialchars($editData['nama']) ?>" required class="form-control" placeholder="Nama">
                </div>
                <div class="col-md-4">
                    <label for="umur" class="form-label">Umur</label>
                    <input type="number" name="umur" id="umur" value="<?= htmlspecialchars($editData['umur']) ?>" required min="1" class="form-control" placeholder="Umur">
                </div>
                <div class="col-md-4">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" required class="form-select">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" <?= $editData['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="Perempuan" <?= $editData['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="departemen" class="form-label">Departemen</label>
                    <input type="text" name="departemen" id="departemen" value="<?= htmlspecialchars($editData['departemen']) ?>" required class="form-control" placeholder="Departemen">
                </div>
                <div class="col-md-6">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <input type="text" name="jabatan" id="jabatan" value="<?= htmlspecialchars($editData['jabatan']) ?>" required class="form-control" placeholder="Jabatan">
                </div>
                <div class="col-md-6">
                    <label for="kota_asal" class="form-label">Kota Asal</label>
                    <input type="text" name="kota_asal" id="kota_asal" value="<?= htmlspecialchars($editData['kota_asal']) ?>" required class="form-control" placeholder="Kota Asal">
                </div>
                <div class="col-md-4">
                    <label for="tanggal_absensi" class="form-label">Tanggal Absensi</label>
                    <input type="date" name="tanggal_absensi" id="tanggal_absensi" value="<?= htmlspecialchars($editData['tanggal_absensi']) ?>" required class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="jam_masuk" class="form-label">Jam Masuk</label>
                    <input type="time" name="jam_masuk" id="jam_masuk" value="<?= htmlspecialchars($editData['jam_masuk']) ?>" required class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="jam_pulang" class="form-label">Jam Pulang</label>
                    <input type="time" name="jam_pulang" id="jam_pulang" value="<?= htmlspecialchars($editData['jam_pulang']) ?>" required class="form-control">
                </div>

                <div class="col-12 d-flex gap-2">
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                    <a href="data.php" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
