// ... (kode untuk toggle sidebar dan pratinjau gambar) ...

// 3. Logika untuk Grafik di Dashboard
const contentChartCanvas = document.getElementById('contentChart');
if (contentChartCanvas && typeof window.dashboardData !== 'undefined') {
    const data = {
        labels: ['Berita', 'Galeri', 'Perangkat Desa'],
        datasets: [{
            label: 'Total Konten',
            data: [
                window.dashboardData.jumlahBerita,
                window.dashboardData.jumlahGaleri,
                window.dashboardData.jumlahPerangkat
            ],
            backgroundColor: [
                'rgba(74, 144, 226, 0.7)',
                'rgba(80, 227, 194, 0.7)',
                'rgba(248, 231, 28, 0.7)'
            ],
            borderColor: [
                '#4A90E2',
                '#50E3C2',
                '#F8E71C'
            ],
            borderWidth: 1
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } }
            },
            plugins: {
                legend: { display: false }
            },
            responsive: true,
            maintainAspectRatio: false
        }
    };

    new Chart(contentChartCanvas, config);
}

// di dalam file assets/js/admin.js

document.addEventListener("DOMContentLoaded", function() {
    // ... (kode toggle sidebar) ...

    // --- LOGIKA UNTUK CROPPER.JS ---
    const imageInput = document.getElementById('imageInput');
    const imageToCrop = document.getElementById('imageToCrop');
    const cropModalEl = document.getElementById('cropModal');
    const cropButton = document.getElementById('cropButton');
    const croppedImageDataInput = document.getElementById('croppedImageData');
    const imagePreview = document.getElementById('imagePreview');
    let cropper;
    let cropModal;

    if (cropModalEl) {
        cropModal = new bootstrap.Modal(cropModalEl);
    }

    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const files = e.target.files;
            if (files && files.length > 0) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    imageToCrop.src = event.target.result;
                    cropModal.show();
                };
                reader.readAsDataURL(files[0]);
            }
        });
    }

    if (cropModalEl) {
        cropModalEl.addEventListener('shown.bs.modal', function() {
            if (cropper) {
                cropper.destroy();
            }
            cropper = new Cropper(imageToCrop, {
                aspectRatio: 1 / 1, // Untuk foto profil persegi
                viewMode: 1,
                autoCropArea: 0.8,
            });
        });
    }

    if (cropButton) {
        cropButton.addEventListener('click', function() {
            const canvas = cropper.getCroppedCanvas({
                width: 500,  // Ukuran gambar hasil crop
                height: 500,
            });

            // Tampilkan pratinjau di halaman form
            imagePreview.src = canvas.toDataURL('image/jpeg');

            // Simpan data gambar base64 ke input tersembunyi
            canvas.toBlob(function(blob) {
                const reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    croppedImageDataInput.value = reader.result;
                }
            }, 'image/jpeg');

            cropModal.hide();
        });
    }
});