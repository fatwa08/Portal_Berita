<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>Portal Berita Modern</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="app-layout">
    <aside class="sidebar">
        <div class="sidebar-header">
            <a href="index.php" class="logo">Media Digital</a>
        </div>
        <nav class="sidebar-nav">
            <ul>
                <li><a href="index.php">Home</a></li>
            </ul>
            <h3>Kategori</h3>
            <ul>
                <?php
                // Query ini yang menyebabkan error jika tabel 'kategori' tidak ada.
                $sql_kategori = "SELECT nama_kategori, slug_kategori FROM kategori ORDER BY nama_kategori ASC";
                $result_kategori = $koneksi->query($sql_kategori);
                if ($result_kategori && $result_kategori->num_rows > 0) {
                    while($row = $result_kategori->fetch_assoc()) {
                        echo '<li><a href="kategori.php?slug=' . $row['slug_kategori'] . '">' . htmlspecialchars($row['nama_kategori']) . '</a></li>';
                    }
                }
                ?>
            </ul>
        </nav>
    </aside>
    <main class="main-content">