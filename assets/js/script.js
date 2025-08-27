// assets/js/script.js

document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.header');

    window.addEventListener('scroll', function() {
        // Jika scroll lebih dari 50px dari atas, tambahkan class 'scrolled'
        // Jika tidak, hapus class 'scrolled'
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });
});

document.addEventListener("DOMContentLoaded", function() {
    var sidebarToggle = document.getElementById("sidebarToggle");
    var adminWrapper = document.getElementById("adminWrapper");

    if (sidebarToggle && adminWrapper) {
        sidebarToggle.addEventListener("click", function(e) {
            e.preventDefault();
            adminWrapper.classList.toggle("toggled");
        });
    }
});