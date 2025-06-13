<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Timeline Pengalaman Kuliah</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; }
        .timeline { max-width: 800px; margin: 20px auto; position: relative; }
        .timeline::before {
            content: '';
            position: absolute;
            left: 50px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #3498db;
        }
        .timeline-item { margin-bottom: 30px; position: relative; }
        .timeline-item::before {
            content: '';
            position: absolute;
            left: 44px;
            top: 8px;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: #3498db;
        }
        .timeline-content {
            margin-left: 90px;
            padding: 15px 20px;
            background: #fff;
            border-radius: 6px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; }
        .button-group { text-align: center; margin-top: 40px; }
        .button-group a {
            padding: 10px 20px;
            margin: 0 10px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .button-group a:hover { background: #2980b9; }
    </style>
</head>
<body>
<h2>Timeline Pengalaman Kuliah</h2>
<div class="timeline">
<?php
// Fungsi untuk menampilkan timeline
function tampilkan_timeline($data) {
    foreach ($data as $item) {
        echo "<div class='timeline-item'>";
        echo "<div class='timeline-content'>";
        echo "<h3>{$item['judul']}</h3>";
        echo "<p>{$item['deskripsi']}</p>";
        echo "</div>";
        echo "</div>";
    }
}

// Data pengalaman kuliah (array asosiatif)
$pengalaman = [
    [
        'judul' => 'Semester 1: Adaptasi Kehidupan Kampus',
        'deskripsi' => 'Mengikuti berbagai kegiatan orientasi dan mulai mengenal lingkungan kampus serta teman-teman baru.'
    ],
    [
        'judul' => 'Semester 1-2: Belajar Pemrograman',
        'deskripsi' => 'Mengambil mata kuliah pemrograman dasar dan mulai memahami konsep algoritma serta logika pemrograman.
        Mengambil mata kuliah pemrograman berbasis web dan pemrograman berbasis objek yang dimana mulai memahami berbagai macam pemrograman.'
    ],
];

tampilkan_timeline($pengalaman);
?>
</div>

<div class="button-group">
    <a href="profil.php">Kembali ke Profil</a>
    <a href="blog.php">Menuju Blog</a>
</div>
</body>
</html>
