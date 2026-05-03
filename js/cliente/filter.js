document.addEventListener('click', function (e) {
    const btn = e.target.closest('[data-filter]');
    if (!btn) return;

    const filtro = btn.dataset.filter;

    const contenedor = btn.closest('.nav') || btn.parentElement;

    contenedor.querySelectorAll('[data-filter]')
        .forEach(b => b.classList.remove('active'));

    btn.classList.add('active');

    document.querySelectorAll('.producto-item').forEach(item => {

        const categoria = item.dataset.categoria;

        if (filtro === 'todos') {
            item.classList.remove('d-none');
        } else {
            item.classList.toggle('d-none', categoria != filtro);
        }

    });
});

document.addEventListener('DOMContentLoaded', function () {
    const btnTodos = document.querySelector('[data-filter="todos"]');
    if (btnTodos) btnTodos.click();
});