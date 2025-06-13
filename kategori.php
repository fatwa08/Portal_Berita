<?php
include 'config.php'; // Hubungkan ke db dulu

if (!isset($_GET['slug']) || empty($_GET['slug'])) {
    header("Location: index.php");
    exit();
}

$slug_kategori = $_GET['slug'];

// Ambil nama kategori untuk judul halaman
$sql_cat_info = "SELECT nama_kategori FROM kategori WHERE slug_kategori = ? LIMIT 1";
$stmt_cat_info = $koneksi->prepare($sql_cat_info);
$stmt_cat_info->bind_param("s", $slug_kategori);
$stmt_cat_info->execute();
$result_cat_info = $stmt_cat_info->get_result();

if ($result_cat_info->num_rows === 0) {
    http_response_code(404);
    $page_title = "Kategori Tidak Ditemukan";
    include 'includes/header.php';
    echo "<h1>404</h1><p>Kategori tidak ditemukan.</p>";
    include 'includes/footer.php';
    exit();
}
$kategori_info = $result_cat_info->fetch_assoc();
$page_title = 'Kategori: ' . $kategori_info['nama_kategori'];
$stmt_cat_info->close();

include 'includes/header.php';

// Ambil berita berdasarkan slug kategori
$sql = "SELECT b.judul, b.slug, b.isi_berita, b.gambar, k.nama_kategori, k.slug_kategori
        FROM berita b
        JOIN kategori k ON b.id_kategori = k.id_kategori
        WHERE k.slug_kategori = ?
        ORDER BY b.tanggal_publikasi DESC";

$stmt = $koneksi->prepare($sql);
$stmt->bind_param("s", $slug_kategori);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="page-header">
    <h1>Kategori: <?php echo htmlspecialchars($kategori_info['nama_kategori']); ?></h1>
</div>

<div class="article-grid">
    <?php if ($result->num_rows > 0): ?>
        <?php while($berita = $result->fetch_assoc()): ?>
            <a href="artikel.php?slug=<?php echo $berita['slug']; ?>" class="card">
                <img src="<?php echo htmlspecialchars($berita['gambar']); ?>" alt="<?php echo htmlspecialchars($berita['judul']); ?>" class="card-img">
                <div class="card-body">
                    <h2 class="card-title"><?php echo htmlspecialchars($berita['judul']); ?></h2>
                    <p class="card-text"><?php echo htmlspecialchars(substr($berita['isi_berita'], 0, 100)) . '...'; ?></p>
                </div>
            </a>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Belum ada berita dalam kategori ini.</p>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>