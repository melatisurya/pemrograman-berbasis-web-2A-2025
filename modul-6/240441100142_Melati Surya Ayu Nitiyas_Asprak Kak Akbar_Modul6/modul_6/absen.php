<?php
session_start();
include("koneksi.php");
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$message = "";
$message_class = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nip         = $_POST['nip'];
    $nama        = $_POST['nama'];
    $umur        = $_POST['umur'];
    $jk          = $_POST['jenis_kelamin'];
    $departemen  = $_POST['departemen'];
    $jabatan     = $_POST['jabatan'];
    $kota        = $_POST['kota_asal'];
    $tanggal     = $_POST['tanggal_absensi'];
    $masuk       = $_POST['jam_masuk'];
    $pulang      = $_POST['jam_pulang'];

    // Escape string untuk keamanan
    $nip         = mysqli_real_escape_string($conn, $nip);
    $nama        = mysqli_real_escape_string($conn, $nama);
    $umur        = (int)$umur;
    $jk          = mysqli_real_escape_string($conn, $jk);
    $departemen  = mysqli_real_escape_string($conn, $departemen);
    $jabatan     = mysqli_real_escape_string($conn, $jabatan);
    $kota        = mysqli_real_escape_string($conn, $kota);
    $tanggal     = mysqli_real_escape_string($conn, $tanggal);
    $masuk       = mysqli_real_escape_string($conn, $masuk);
    $pulang      = mysqli_real_escape_string($conn, $pulang);

    // Validasi jam masuk < jam pulang (server-side)
    if (strtotime($masuk) >= strtotime($pulang)) {
        $message = "❌ Jam masuk harus lebih awal dari jam pulang.";
        $message_class = "alert-danger";
    } else {
        $sql = "INSERT INTO karyawan_absensi (nip, nama, umur, jenis_kelamin, departemen, jabatan, kota_asal, tanggal_absensi, jam_masuk, jam_pulang)
                VALUES ('$nip','$nama','$umur','$jk','$departemen','$jabatan','$kota','$tanggal','$masuk','$pulang')";
        
        if (mysqli_query($conn, $sql)) {
            $message = "✅ Data berhasil disimpan!";
            $message_class = "alert-success";
            $_POST = array(); // Reset form
        } else {
            $message = "❌ Gagal menyimpan data: " . mysqli_error($conn);
            $message_class = "alert-danger";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Form Data Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }
        .invalid-feedback {
            display: none;
            font-size: 0.875em;
            color: #dc3545;
        }
        .invalid-feedback.active {
            display: block;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Input Data Karyawan & Absensi</h2>

                        <?php if ($message): ?>
                            <div class="alert <?= $message_class ?>" role="alert">
                                <?= htmlspecialchars($message) ?>
                            </div>
                        <?php endif; ?>

                        <form method="post" novalidate id="karyawanForm">
                            <div class="mb-3">
                                <input type="text" name="nip" id="nip" class="form-control" placeholder="NIP" required
                                    value="<?= isset($_POST['nip']) ? htmlspecialchars($_POST['nip']) : '' ?>" />
                                <div class="invalid-feedback">NIP wajib diisi.</div>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama" required
                                    value="<?= isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : '' ?>" />
                                <div class="invalid-feedback">Nama wajib diisi.</div>
                            </div>
                            <div class="mb-3">
                                <input type="number" name="umur" id="umur" class="form-control" placeholder="Umur" required min="1"
                                    value="<?= isset($_POST['umur']) ? (int)$_POST['umur'] : '' ?>" />
                                <div class="invalid-feedback">Umur wajib diisi dan harus lebih dari 0.</div>
                            </div>
                            <div class="mb-3">
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" <?= (isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin'] == 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
                                    <option value="Perempuan" <?= (isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin'] == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                                </select>
                                <div class="invalid-feedback">Jenis kelamin wajib dipilih.</div>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="departemen" id="departemen" class="form-control" placeholder="Departemen" required
                                    value="<?= isset($_POST['departemen']) ? htmlspecialchars($_POST['departemen']) : '' ?>" />
                                <div class="invalid-feedback">Departemen wajib diisi.</div>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="jabatan" id="jabatan" class="form-control" placeholder="Jabatan" required
                                    value="<?= isset($_POST['jabatan']) ? htmlspecialchars($_POST['jabatan']) : '' ?>" />
                                <div class="invalid-feedback">Jabatan wajib diisi.</div>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="kota_asal" id="kota_asal" class="form-control" placeholder="Kota Asal" required
                                    value="<?= isset($_POST['kota_asal']) ? htmlspecialchars($_POST['kota_asal']) : '' ?>" />
                                <div class="invalid-feedback">Kota asal wajib diisi.</div>
                            </div>
                            <div class="mb-3">
                                <input type="date" name="tanggal_absensi" id="tanggal_absensi" class="form-control" required
                                    value="<?= isset($_POST['tanggal_absensi']) ? htmlspecialchars($_POST['tanggal_absensi']) : '' ?>" />
                                <div class="invalid-feedback">Tanggal absensi wajib diisi.</div>
                            </div>
                            <div class="mb-3">
                                <input type="time" name="jam_masuk" id="jam_masuk" class="form-control" required
                                    value="<?= isset($_POST['jam_masuk']) ? htmlspecialchars($_POST['jam_masuk']) : '' ?>" />
                                <div class="invalid-feedback">Jam masuk wajib diisi.</div>
                            </div>
                            <div class="mb-3">
                                <input type="time" name="jam_pulang" id="jam_pulang" class="form-control" required
                                    value="<?= isset($_POST['jam_pulang']) ? htmlspecialchars($_POST['jam_pulang']) : '' ?>" />
                                <div class="invalid-feedback">Jam pulang wajib diisi.</div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Simpan</button>
                        </form>

                        <a href="dashboard.php" class="btn btn-outline-secondary w-100 mt-3">Kembali ke Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const form = document.getElementById('karyawanForm');

        // Fungsi validasi per input
        function validateInput(input) {
            const feedback = input.nextElementSibling;
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                feedback.classList.add('active');
                return false;
            } else {
                // Khusus untuk umur cek > 0
                if (input.name === 'umur' && Number(input.value) <= 0) {
                    input.classList.add('is-invalid');
                    feedback.classList.add('active');
                    return false;
                }
                input.classList.remove('is-invalid');
                feedback.classList.remove('active');
                return true;
            }
        }

        // Validasi realtime saat input berubah
        form.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('input', () => validateInput(input));
            input.addEventListener('change', () => validateInput(input));
        });

        // Validasi saat submit
        form.addEventListener('submit', function(e) {
            let isFormValid = true;
            form.querySelectorAll('input, select').forEach(input => {
                if (!validateInput(input)) {
                    isFormValid = false;
                }
            });

            // Validasi jam masuk < jam pulang
            const jamMasuk = form.jam_masuk.value;
            const jamPulang = form.jam_pulang.value;
            const jamMasukInput = form.jam_masuk;
            const jamPulangInput = form.jam_pulang;
            const jamMasukFeedback = jamMasukInput.nextElementSibling;
            const jamPulangFeedback = jamPulangInput.nextElementSibling;

            // Reset feedback
            jamMasukInput.classList.remove('is-invalid');
            jamMasukFeedback.classList.remove('active');
            jamPulangInput.classList.remove('is-invalid');
            jamPulangFeedback.classList.remove('active');

            if (jamMasuk && jamPulang && jamMasuk >= jamPulang) {
                isFormValid = false;
                jamMasukInput.classList.add('is-invalid');
                jamMasukFeedback.textContent = "Jam masuk harus lebih awal dari jam pulang.";
                jamMasukFeedback.classList.add('active');
                jamPulangInput.classList.add('is-invalid');
                jamPulangFeedback.textContent = "Jam pulang harus lebih akhir dari jam masuk.";
                jamPulangFeedback.classList.add('active');
            } else {
                // Kembalikan pesan default jika valid
                jamMasukFeedback.textContent = "Jam masuk wajib diisi.";
                jamPulangFeedback.textContent = "Jam pulang wajib diisi.";
            }

            if (!isFormValid) {
                e.preventDefault();
                // Fokus ke input pertama yang invalid
                const firstInvalid = form.querySelector('.is-invalid');
                if (firstInvalid) firstInvalid.focus();
            }
        });
    </script>
</body>
</html>
