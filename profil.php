<?php
require_once 'templates/header.php';

try {
    // Mengambil data profil dari database
    $stmt = $pdo->query("SELECT * FROM profil_desa WHERE id = 1");
    $profil = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Gagal mengambil data profil: " . $e->getMessage());
}
?>

<div class="container" data-aos="fade-in" style="margin-top: 200px;">

    <div class="page-header text-center mb-5">
        <h1 class="display-5 fw-bold section-title-gradient">Profil Desa Tegallurung</h1>
        <p class="lead text-muted col-lg-8 mx-auto">Mengenal lebih dalam tentang sejarah, visi, dan misi yang menjadi landasan pembangunan desa kami.</p>
    </div>

    <section id="sejarah" class="mb-5">
        <div class="card shadow-sm" data-aos="fade-up">
            <div class="card-header bg-primary bg-gradient text-white fs-5 fw-bold">
                📜 Sejarah Desa
            </div>
            <div class="card-body p-4">
                <p class="card-text lh-lg"><?= nl2br(htmlspecialchars($profil['sejarah'])); ?></p>
            </div>
        </div>
    </section>

    <section id="visi-misi">
        <div class="row g-4">
            <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-success bg-gradient text-white fs-5 fw-bold">
                        🎯 Visi
                    </div>
                    <div class="card-body p-4">
                        <p class="card-text fst-italic fs-5">"<?= htmlspecialchars($profil['visi']); ?>"</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-secondary bg-gradient text-white fs-5 fw-bold">
                        ✨ Misi
                    </div>
                    <div class="card-body p-4">
                        <ol class="list-group list-group-flush">
                            <?php
                            // Memecah teks Misi menjadi baris-baris
                            $misi_items = explode("\n", trim($profil['misi']));
                            foreach ($misi_items as $item) {
                                // Hanya tampilkan baris yang tidak kosong
                                if (!empty(trim($item))) {
                                    echo '<li class="list-group-item">' . htmlspecialchars(trim($item)) . '</li>';
                                }
                            }
                            ?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<?php require_once 'templates/footer.php'; ?>