</main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL; ?>assets/js/admin.js"></script>
<script>
    AOS.init({ duration: 600, once: true });

    <?php if (isset($_SESSION['toast_message'])): ?>
        const toastEl = document.getElementById('notificationToast');
        if (toastEl) {
            const toastBody = toastEl.querySelector('.toast-body');
            if(toastBody) toastBody.textContent = "<?= htmlspecialchars($_SESSION['toast_message']); ?>";
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        }
        <?php unset($_SESSION['toast_message']); ?>
    <?php endif; ?>
</script>
</body>
</html>