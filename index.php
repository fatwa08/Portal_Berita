<?php
$page_title = 'Berita Terbaru';
include 'includes/header.php';

// --- Logika Pagination ---
$berita_per_halaman = 6; // Jumlah berita per halaman

// Hitung total berita
$sql_total = "SELECT COUNT(*) AS total FROM berita";
$result_total = $koneksi->query($sql_total);
$total_berita = $result_total->fetch_assoc()['total'];
$total_halaman = ceil($total_berita / $berita_per_halaman);

// Tentukan halaman saat ini
$halaman_aktif = (isset($_GET['halaman'])) ? (int)$_GET['halaman'] : 1;
if ($halaman_aktif < 1) $halaman_aktif = 1;
if ($halaman_aktif > $total_halaman) $halaman_aktif = $total_halaman;

// Hitung offset
$offset = ($halaman_aktif - 1) * $berita_per_halaman;

// --- Ambil Data Berita Sesuai Halaman ---
$sql = "SELECT b.judul, b.slug, b.isi_berita, b.gambar, b.tanggal_publikasi, k.nama_kategori, k.slug_kategori
        FROM berita b
        JOIN kategori k ON b.id_kategori = k.id_kategori
        ORDER BY b.tanggal_publikasi DESC
        LIMIT ? OFFSET ?";

$stmt = $koneksi->prepare($sql);
$stmt->bind_param("ii", $berita_per_halaman, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="page-header">
    <h1>Highlight Terkini</h1>
</div>

<div class="article-grid">
    <?php if ($result->num_rows > 0): ?>
        <?php while($berita = $result->fetch_assoc()): ?>
            <a href="artikel.php?slug=<?php echo $berita['slug']; ?>" class="card">
                <img src="<?php echo htmlspecialchars($berita['gambar']); ?>" alt="<?php echo htmlspecialchars($berita['judul']); ?>" class="card-img">
                <div class="card-body">
                    <span href="kategori.php?slug=<?php echo $berita['slug_kategori']; ?>" class="card-category"><?php echo htmlspecialchars($berita['nama_kategori']); ?></span>
                    <h2 class="card-title"><?php echo htmlspecialchars($berita['judul']); ?></h2>
                    <p class="card-text"><?php echo htmlspecialchars(substr($berita['isi_berita'], 0, 100)) . '...'; ?></p>
                </div>
            </a>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Tidak ada berita untuk ditampilkan.</p>
    <?php endif; ?>
</div>

<nav class="pagination">
    <?php if ($halaman_aktif > 1): ?>
        <a href="?halaman=<?php echo $halaman_aktif - 1; ?>">&laquo; Sebelumnya</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_halaman; $i++): ?>
        <a href="?halaman=<?php echo $i; ?>" class="<?php echo ($i == $halaman_aktif) ? 'current' : ''; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>

    <?php if ($halaman_aktif < $total_halaman): ?>
        <a href="?halaman=<?php echo $halaman_aktif + 1; ?>">Selanjutnya &raquo;</a>
    <?php endif; ?>
</nav>


<?php include 'includes/footer.php'; ?>