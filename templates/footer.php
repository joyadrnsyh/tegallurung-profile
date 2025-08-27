<?php
// Letakkan kode ini di bagian atas file footer.php atau di header.php
try {
    $stmt_kontak = $pdo->query("SELECT * FROM kontak_info WHERE id = 1");
    $kontak = $stmt_kontak->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Data default jika query gagal
    $kontak = [
        'deskripsi_singkat' => 'Informasi desa.',
        'alamat' => 'Alamat belum diatur.',
        'email' => 'email@desa.id',
        'telepon' => 'Nomor belum diatur.',
        'link_facebook' => '#',
        'link_instagram' => '#',
        'link_youtube' => '#'
    ];
}
?>

</main> <footer class="footer-modern bg-dark text-white pt-5 pb-4">
    <div class="container text-center text-md-start">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6">
                <h5 class="text-uppercase fw-bold mb-4">Desa Tegallurung</h5>
                <p><?= htmlspecialchars($kontak['deskripsi_singkat']); ?></p>
            </div>
            <div class="col-lg-2 col-md-6">
                <h5 class="text-uppercase fw-bold mb-4">Tautan</h5>
                <ul class="list-unstyled">
                    <li><a href="profil.php" class="footer-link">Profil</a></li>
                    <li><a href="berita.php" class="footer-link">Berita</a></li>
                    <li><a href="galeri.php" class="footer-link">Galeri</a></li>
                    <li><a href="perangkat.php" class="footer-link">Perangkat Desa</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6">
                <h5 class="text-uppercase fw-bold mb-4">Kontak</h5>
                <ul class="list-unstyled">
                    <li><i class='bx bxs-map me-2'></i> <?= htmlspecialchars($kontak['alamat']); ?></li>
                    <li><i class='bx bxs-envelope me-2'></i> <?= htmlspecialchars($kontak['email']); ?></li>
                    <li><i class='bx bxs-phone me-2'></i> <?= htmlspecialchars($kontak['telepon']); ?></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 text-center">
                <h5 class="text-uppercase fw-bold mb-4">Ikuti Kami</h5>
                
                <a href="<?= htmlspecialchars($kontak['link_facebook']); ?>" target="_blank" class="social-icon">
                    <i class='bx bxl-facebook-circle'></i>
                </a>
                
                <a href="<?= htmlspecialchars($kontak['link_instagram']); ?>" target="_blank" class="social-icon">
                    <i class='bx bxl-instagram-alt'></i>
                </a>
                
                <a href="<?= htmlspecialchars($kontak['link_youtube']); ?>" target="_blank" class="social-icon">
                    <i class='bx bxl-youtube'></i>
                </a>
            </div>
        </div>
    </div>
    <div class="text-center p-3 mt-4" style="background-color: rgba(0, 0, 0, 0.2);">&copy; <?= date('Y'); ?> Desa Tegallurung. All Rights Reserved.</div>
</footer>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script src="<?= BASE_URL; ?>assets/js/script.js"></script>
<script src="<?= BASE_URL; ?>assets/js/admin.js"></script> <script>
  // Inisialisasi AOS
  AOS.init({
    duration: 800,
    once: true,
  });
</script>

</body>
</html>