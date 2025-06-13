<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Interaktif Mahasiswa</title>
    <style>
        body { font-family: Arial,; background:rgb(214, 209, 209); }
        font-family: Arial, sans-serif;
        background: rgb(255, 255, 255);
        color: #333;
        line-height: 1.6;
        padding: 20px;
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
        }
        table {
            border-collapse: collapse;
            margin-bottom: 20px;
            width: 60%;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color:rgb(156, 176, 189);
            color: white;
        }
        form {
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            color: #2c3e50;
        }
        input[type="text"], textarea, select {
            width: 60%;
            padding: 8px;
            margin-top: 4px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .error {
            color: red;
            margin-top: 5px;
            font-size: 0.9em;
        }
        .checkbox-group, .radio-group {
            margin-top: 6px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .checkbox-group label, .radio-group label {
            font-weight: normal;
            margin-right: 15px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .submit-btn {
            margin-top: 15px;
            padding: 8px 15px;
            font-size: 16px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #2980b9;
        }
        hr {
            margin: 20px 0;
            border: none;
            border-top: 1px solid #eee;
        }
        a {
            margin-top: 15px;
            padding: 8px 15px;
            font-size: 16px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color:rgb(255, 255, 255);
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>
<h1>Profil Interaktif Mahasiswa</h1>

<table>
    <tr><th>Nama</th><td>Melati Surya Ayu Nitiyas</td></tr>
    <tr><th>NIM</th><td>240441100142</td></tr>
    <tr><th>Tempat, Tanggal Lahir</th><td>Jombang, 09 April 2006</td></tr>
    <tr><th>Email</th><td>melatisurya6@gmail.com</td></tr>
    <tr><th>Nomor HP</th><td>085850533206</td></tr>
</table>

<?php
function validasi_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$errors = [];
$bahasa = [];
$pengalaman = "";
$software = [];
$sistem_operasi = "";
$tingkat_php = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi Bahasa Pemrograman
    if (isset($_POST['bahasa']) && is_array($_POST['bahasa'])) {
        $bahasa = array_filter(array_map('validasi_input', $_POST['bahasa']));
        if (empty($bahasa)) $errors['bahasa'] = "Harap isi minimal satu bahasa pemrograman.";
    } else {
        $errors['bahasa'] = "Harap isi bahasa pemrograman yang dikuasai.";
    }

    // Validasi Pengalaman
    if (isset($_POST['pengalaman']) && trim($_POST['pengalaman']) !== "") {
        $pengalaman = validasi_input($_POST['pengalaman']);
    } else {
        $errors['pengalaman'] = "Harap isi penjelasan pengalaman membuat proyek pribadi.";
    }

    // Validasi Software
    if (isset($_POST['software']) && is_array($_POST['software']) && count($_POST['software']) > 0) {
        $software = $_POST['software'];
    } else {
        $errors['software'] = "Harap pilih minimal satu software yang sering digunakan.";
    }

    // Validasi Sistem Operasi
    if (isset($_POST['sistem_operasi']) && in_array($_POST['sistem_operasi'], ['Windows', 'Linux', 'Mac'])) {
        $sistem_operasi = validasi_input($_POST['sistem_operasi']);
    } else {
        $errors['sistem_operasi'] = "Harap pilih sistem operasi yang digunakan.";
    }

    // Validasi Tingkat PHP
    if (isset($_POST['tingkat_php']) && in_array($_POST['tingkat_php'], ['Pemula', 'Menengah', 'Mahir'])) {
        $tingkat_php = validasi_input($_POST['tingkat_php']);
    } else {
        $errors['tingkat_php'] = "Harap pilih tingkat penguasaan PHP.";
    }
}
?>

<form method="post" action="">
    <label>Bahasa Pemrograman yang Dikuasai (bisa lebih dari satu):</label>
    <input type="text" name="bahasa[]" placeholder="Bahasa pemrograman 1" value="<?php echo isset($bahasa[0]) ? htmlspecialchars($bahasa[0]) : ''; ?>"><br>
    <input type="text" name="bahasa[]" placeholder="Bahasa pemrograman 2" value="<?php echo isset($bahasa[1]) ? htmlspecialchars($bahasa[1]) : ''; ?>"><br>
    <input type="text" name="bahasa[]" placeholder="Bahasa pemrograman 3" value="<?php echo isset($bahasa[2]) ? htmlspecialchars($bahasa[2]) : ''; ?>"><br>
    <?php if (isset($errors['bahasa'])) echo '<div class="error">'.$errors['bahasa'].'</div>'; ?>

    <label>Penjelasan singkat tentang pengalaman membuat proyek pribadi:</label>
    <textarea name="pengalaman" rows="4"><?php echo htmlspecialchars($pengalaman); ?></textarea>
    <?php if (isset($errors['pengalaman'])) echo '<div class="error">'.$errors['pengalaman'].'</div>'; ?>

    <label>Software yang sering digunakan:</label>
    <div class="checkbox-group">
        <?php
        $list_software = ['VS Code', 'XAMPP', 'Git', 'Sublime Text', 'Docker'];
        foreach ($list_software as $sw) {
            $checked = in_array($sw, $software) ? 'checked' : '';
            echo "<label><input type='checkbox' name='software[]' value='$sw' $checked> $sw</label>";
        }
        ?>
    </div>
    <?php if (isset($errors['software'])) echo '<div class="error">'.$errors['software'].'</div>'; ?>

    <label>Sistem Operasi yang Digunakan:</label>
    <div class="radio-group">
        <?php
        $list_os = ['Windows', 'Linux', 'Mac'];
        foreach ($list_os as $os) {
            $checked = ($sistem_operasi == $os) ? 'checked' : '';
            echo "<label><input type='radio' name='sistem_operasi' value='$os' $checked> $os</label>";
        }
        ?>
    </div>
    <?php if (isset($errors['sistem_operasi'])) echo '<div class="error">'.$errors['sistem_operasi'].'</div>'; ?>

    <label>Tingkat Penguasaan PHP:</label>
    <select name="tingkat_php">
        <option value="">-- Pilih Tingkat --</option>
        <?php
        $list_php = ['Pemula', 'Menengah', 'Mahir'];
        foreach ($list_php as $level) {
            $selected = ($tingkat_php == $level) ? 'selected' : '';
            echo "<option value='$level' $selected>$level</option>";
        }
        ?>
    </select>
    <?php if (isset($errors['tingkat_php'])) echo '<div class="error">'.$errors['tingkat_php'].'</div>'; ?>

    <br>
    <input type="submit" value="Submit" class="submit-btn">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($errors)) {
    echo "<h2>Hasil Input Anda</h2>";
    echo "<table>";
    echo "<tr><th>Bahasa Pemrograman yang Dikuasai</th><td>" . implode(", ", array_map('htmlspecialchars', $bahasa)) . "</td></tr>";
    echo "<tr><th>Software yang Sering Digunakan</th><td>" . implode(", ", array_map('htmlspecialchars', $software)) . "</td></tr>";
    echo "<tr><th>Sistem Operasi yang Digunakan</th><td>" . htmlspecialchars($sistem_operasi) . "</td></tr>";
    echo "<tr><th>Tingkat Penguasaan PHP</th><td>" . htmlspecialchars($tingkat_php) . "</td></tr>";
    echo "</table>";
    echo "<p><strong>Pengalaman membuat proyek pribadi:</strong><br>" . nl2br(htmlspecialchars($pengalaman)) . "</p>";
    if (count($bahasa) > 2) {
        echo "<p><em>Anda cukup berpengalaman dalam pemrograman!</em></p>";
    }
}
?>
<hr>
<p><a href="timeline.php">Menuju Timeline Pengalaman Kuliah</a>
<a href="blog.php">Menuju blog</a></p>
</body>
</html>
