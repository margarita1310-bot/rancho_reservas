document.addEventListener('click', (e) => {
    const btn = e.target.closest('[data-filter]');
    if (!btn) return;

    const filtro = btn.dataset.filter;

    const modulo = btn.closest('[id]');
    if (!modulo) return;

    const table = modulo.querySelector('table');
    if (!table) return;

    btn.parentElement.querySelectorAll('button').forEach(b =>
        b.classList.remove('btn-active', 'filter-btn-active')
    );

    btn.classList.add('btn-active', 'filter-btn-active');

    table.querySelectorAll('tbody tr').forEach(row => {
        if (filtro === 'todas' || filtro === 'todos') {
            row.classList.remove('d-none');
            return;
        }

        row.classList.toggle('d-none', row.dataset.estado !== filtro.slice(0, -1));
    });
});

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-filter="todas"]').forEach(btn => {
        btn.click();
    });
});
