<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Blog Reflektif</title>
    <style>
        body {
            background: #f3f4f6;
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .header {
            background: #2576e7;
            color: #fff;
            padding: 28px 0 18px 0;
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            letter-spacing: 1px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.03);
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08), 0 1.5px 3px rgba(0,0,0,0.03);
            padding: 32px 36px 28px 36px;
        }
        .blog-list {
            margin-bottom: 30px;
        }
        .blog-list a {
            color: #2576e7;
            text-decoration: underline;
            font-size: 1.1rem;
            display: block;
            margin-bottom: 8px;
            transition: color 0.2s;
        }
        .blog-list a:hover {
            color: #1b4f9c;
        }
        .blog-date {
            color: #888;
            font-size: 0.98rem;
            margin-left: 4px;
        }
        .button-row {
            display: flex;
            justify-content: space-between;
            margin-top: 18px;
        }
        .btn {
            padding: 8px 18px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            background: #e5e5e5;
            color: #333;
            transition: background 0.2s;
        }
        .btn.primary {
            background: #2576e7;
            color: #fff;
        }
        .btn.primary:hover {
            background: #1956a3;
        }
        .btn:hover {
            background: #d4d4d4;
        }
        @media (max-width: 700px) {
            .container {
                padding: 20px 10px 18px 10px;
                max-width: 96vw;
            }
            .header {
                font-size: 1.3rem;
                padding: 20px 0 12px 0;
            }
        }
    </style>
</head>
<body>
    
    <div class="header ">
        Blog Reflektif
    </div>
    <div class="container">
        <?php
        // Fungsi buatan sendiri: ambil kutipan acak
        function ambil_kutipan_acak($kutipan) {
            $index = rand(0, count($kutipan) - 1);
            return $kutipan[$index];
        }

        $kutipan_motivasi = [
            "Jangan pernah menyerah pada impianmu.",
            "Kegagalan adalah awal dari keberhasilan.",
            "Setiap hari adalah kesempatan baru untuk berubah.",
            "Kerja keras tidak pernah menghianati hasil."
        ];

        // Array artikel blog
        $artikel = [
            [
                'judul' => 'Pembelajaran Pemrograman Bagi Pemula',
                'tanggal' => 'Jumat, 19 Nopember 2021 16:26:35',
                'refleksi' => 'Semester baru bagi pemula membawa suasana berbeda. Awalnya berat, tapi perlahan saya mulai terbiasa dengan jadwal dan tugas yang diberikan.',
                'referensi' => 'https://sistem-informasi-s1.stekom.ac.id/informasi/baca/Tips-Belajar-Coding-Untuk-Pemula/5b88bcc2c54c2e94c2e91b4f47f09f3031c82c36'
            ],
        ];

        // Cek apakah ada parameter GET artikel
        $artikel_dipilih = null;
        if (isset($_GET['id']) && isset($artikel[$_GET['id']])) {
            $artikel_dipilih = $artikel[$_GET['id']];
        }
        ?>

        <?php if ($artikel_dipilih): ?>
            <!-- Tampilkan detail artikel -->
            <div class="article">
                <h2><?php echo htmlspecialchars($artikel_dipilih['judul']); ?></h2>
                <p><em>Tanggal posting: <?php echo $artikel_dipilih['tanggal']; ?></em></p>
                <p><?php echo nl2br(htmlspecialchars($artikel_dipilih['refleksi'])); ?></p>
                <div class="quote"><?php echo ambil_kutipan_acak($kutipan_motivasi); ?></div>
                
                <?php if ($artikel_dipilih['referensi']): ?>
                    <p><a href="<?php echo $artikel_dipilih['referensi']; ?>" target="_blank">Sumber referensi</a></p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <!-- Tampilkan daftar artikel -->
            <h2>Daftar Artikel</h2>
            <?php foreach ($artikel as $id => $item): ?>
                <div class="article">
                    <h3><a href="blog.php?id=<?php echo $id; ?>"><?php echo htmlspecialchars($item['judul']); ?></a></h3>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="button-row">
            <button class="btn" onclick="window.location.href='timeline.php'">Kembali ke Timeline</button>
            <button class="btn primary" onclick="window.location.href='profil.php'">Kembali ke Profil</button>
        </div>
    </div>
</body>
</html>
