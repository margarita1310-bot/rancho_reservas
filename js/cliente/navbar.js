window.addEventListener("scroll", function() {
    const navbar = document.querySelector(".navbar");
    const hero = document.querySelector(".hero-section");
    const heroHeight = hero.offsetHeight;
    
    if (window.scrollY < heroHeight - 50) {
        navbar.style.backgroundColor = "transparent";
    } else {
        navbar.style.backgroundColor = "rgba(32, 13, 2, 0.6)";
    }
});

document.querySelectorAll('.offcanvas .nav-link').forEach(link => {
    link.addEventListener('click', function (e) {
        e.preventDefault();

        const targetId = this.getAttribute('href');
        const target = document.querySelector(targetId);

        const offcanvas = bootstrap.Offcanvas.getInstance(
            document.getElementById('offcanvasTop')
        );

        offcanvas.hide();

        setTimeout(() => {
            target.scrollIntoView({ behavior: 'smooth' });
        }, 300);
    });
});