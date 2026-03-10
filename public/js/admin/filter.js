document.addEventListener('click', function (e) {

    const btn = e.target.closest('[data-filter]');
    if (!btn) return;

    const filtro = btn.dataset.filter;

    const contenedor = btn.closest('.filtros-container') || btn.parentElement;
    const tabla = document.querySelector('table'); // si solo tienes una tabla

    if (!tabla) return;

    // Quitar clase active de todos los botones del grupo
    contenedor.querySelectorAll('[data-filter]')
        .forEach(b => b.classList.remove('active'));

    // Activar el botón actual
    btn.classList.add('active');

    // Filtrar filas
    tabla.querySelectorAll('tbody tr').forEach(row => {

        const estadoFila = row.dataset.estado;

        if (filtro === 'todos') {
            row.classList.remove('d-none');
        } else {
            row.classList.toggle('d-none', estadoFila !== filtro);
        }

    });

});

document.addEventListener('DOMContentLoaded', function () {
    const btnTodos = document.querySelector('[data-filter="todos"]');
    if (btnTodos) btnTodos.click();
});