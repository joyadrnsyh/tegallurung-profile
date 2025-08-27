<?php require_once 'templates/header.php'; ?>

<?php
// Letakkan kode ini di bagian atas file index.php, setelah require_once
try {
    $stmt_hero = $pdo->query("SELECT * FROM hero_section WHERE id = 1");
    $hero = $stmt_hero->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Data default jika query gagal
    $hero = [
        'judul' => 'Selamat Datang di Desa Tegallurung',
        'subjudul' => 'Website informasi resmi desa.',
        'tombol_teks' => 'Lihat Layanan',
        'tombol_url' => '#layanan'
    ];
}
?>

<div class="hero-gradient text-white text-center p-5">
    <div class="container py-5" data-aos="zoom-in">
        <h1 class="display-4 fw-bold"><?= htmlspecialchars($hero['judul']); ?></h1>
        <p class="lead col-lg-8 mx-auto"><?= htmlspecialchars($hero['subjudul']); ?></p>
        <a href="<?= htmlspecialchars($hero['tombol_url']); ?>" class="btn btn-warning btn-lg mt-3 fw-bold"><?= htmlspecialchars($hero['tombol_teks']); ?></a>
    </div>
</div>
<div class="container my-5">

<section id="layanan" class="py-5">
    <h2 class="text-center mb-5 fw-bold section-title-gradient" data-aos="fade-down">Layanan & Potensi Desa</h2>
    <div class="row g-4 justify-content-center">
        <?php
        try {
            $stmt_layanan = $pdo->query("SELECT * FROM layanan ORDER BY id ASC");
            $layanan_list = $stmt_layanan->fetchAll(PDO::FETCH_ASSOC);
            $delay = 0;
            foreach ($layanan_list as $layanan) {
                $delay += 100;
        ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= $delay; ?>">
                <div class="card h-100 text-center shadow-sm">
                    <div class="card-body p-4">
                        <div class="feature-icon bg-primary bg-gradient text-white fs-1 rounded-circle mb-4 mt-n5 d-inline-flex align-items-center justify-content-center">
                            <?= htmlspecialchars($layanan['ikon']); ?>
                        </div>
                        <h3 class="card-title fw-bold"><?= htmlspecialchars($layanan['judul']); ?></h3>
                        <p class="card-text"><?= htmlspecialchars($layanan['deskripsi']); ?></p>
                    </div>
                </div>
            </div>
        <?php
            }
        } catch (PDOException $e) {
            echo "<p class='text-danger'>Gagal memuat layanan.</p>";
        }
        ?>
    </div>
</section>

    <section id="berita" class="py-5">
        <h2 class="text-center mb-5 fw-bold section-title-gradient" data-aos="fade-down">Info & Kegiatan Terbaru</h2>
        <div class="row g-4">
            <?php
            try {
                $stmt = $pdo->query("SELECT * FROM berita ORDER BY tanggal_publikasi DESC LIMIT 3");
                $delay = 0;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $delay += 100;
            ?>
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= $delay; ?>">
                    <div class="card h-100 shadow-sm">
                        <img class="card-img-top" src="<?= BASE_URL . 'assets/images/berita/' . htmlspecialchars($row['gambar']); ?>"  alt="Gambar Berita" style="aspect-ratio: 16/10; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold"><?= htmlspecialchars($row['judul']); ?></h5>
                            <small class="text-muted mb-2"><?= date('d F Y', strtotime($row['tanggal_publikasi'])); ?></small>
                            <p class="card-text flex-grow-1"><?= htmlspecialchars(limit_text($row['konten'], 20)); ?></p>
                            <a href="berita_detail.php?id=<?= $row['id']; ?>" class="btn btn-primary mt-auto">Baca Selengkapnya</a>
                        </div>
                    </div>
                </div>
            <?php
                }
            } catch (PDOException $e) {
                echo "<p class='text-danger'>Gagal mengambil data berita.</p>";
            }
            ?>
        </div>
        <div class="text-center mt-5">
            <a href="berita.php" class="btn btn-outline-primary btn-lg">Lihat Semua Berita</a>
        </div>
    </section>

</div>

<?php require_once 'templates/footer.php'; ?>