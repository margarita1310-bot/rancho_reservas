document.querySelectorAll('#sidebarMenu .nav-link').forEach(link => {
    link.addEventListener('click', () => {
        const sidebarEl = document.getElementById('sidebarMenu');
        const offcanvas = bootstrap.Offcanvas.getInstance(sidebarEl);

        if (offcanvas && window.innerWidth < 768) {
            offcanvas.hide();
        }
    });
});