document.querySelectorAll('#sidebarMenu .nav-link').forEach(link => {
    link.addEventListener('click', () => {
        const sidebarEl = document.getElementById('sidebarMenu');
        const offcanvas = bootstrap.Offcanvas.getInstance(sidebarEl);

        if (offcanvas && window.innerWidth < 768) {
            offcanvas.hide();
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {

    const sidebar = document.getElementById("sidebarMenu");
    const toggleBtn = document.getElementById("toggleSidebarBtn");
    const icon = toggleBtn.querySelector("i");

    sidebar.addEventListener("show.bs.collapse", function () {
        icon.classList.remove("bi-list");
        icon.classList.add("bi-x-lg");
    });

    sidebar.addEventListener("hide.bs.collapse", function () {
        icon.classList.remove("bi-x-lg");
        icon.classList.add("bi-list");
    });

});