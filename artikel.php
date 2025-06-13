<?php
include 'config.php'; // Hubungkan ke db dulu untuk ambil judul

if (!isset($_GET['slug']) || empty($_GET['slug'])) {
    header("Location: index.php");
    exit();
}

$slug = $_GET['slug'];

$sql = "SELECT b.judul, b.isi_berita, b.gambar, b.tanggal_publikasi, k.nama_kategori, k.slug_kategori
        FROM berita b
        JOIN kategori k ON b.id_kategori = k.id_kategori
        WHERE b.slug = ?
        LIMIT 1";

$stmt = $koneksi->prepare($sql);
$stmt->bind_param("s", $slug);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    http_response_code(404);
    $page_title = "404 Not Found";
    include 'includes/header.php';
    echo "<h1>404</h1><p>Artikel tidak ditemukan.</p>";
    include 'includes/footer.php';
    exit();
}

$berita = $result->fetch_assoc();
$page_title = $berita['judul'];
include 'includes/header.php';
?>

<article class="article-single">
    <header class="article-single-header">
        <h1><?php echo htmlspecialchars($berita['judul']); ?></h1>
        <div class="article-meta">
            Oleh Tim Redaksi | Kategori: <a href="kategori.php?slug=<?php echo $berita['slug_kategori']; ?>"><?php echo htmlspecialchars($berita['nama_kategori']); ?></a> | 
            Dipublikasikan pada <?php echo date('d F Y', strtotime($berita['tanggal_publikasi'])); ?>
        </div>
    </header>

    <img src="<?php echo htmlspecialchars($berita['gambar']); ?>" alt="<?php echo htmlspecialchars($berita['judul']); ?>" class="article-full-image">

    <div class="article-content">
        <?php echo nl2br(htmlspecialchars($berita['isi_berita'])); ?>
    </div>
</article>

<?php include 'includes/footer.php'; ?>