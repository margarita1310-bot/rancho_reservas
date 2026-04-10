document.addEventListener('DOMContentLoaded', () => {
    const modalGlobal = document.getElementById('modalGlobal');

    if (modalGlobal) {
        modalGlobal.addEventListener('shown.bs.modal', () => {
            configurarFechaEvento();
            configurarFechasPromocion();
        });
    }
});
function abrirModal ({
    titulo,
    contenido,
    textoBoton = "Guardar",
    claseBoton = "btn-primary",
    onSubmit })
    {
        const modalGlobal = document.getElementById('modalGlobal');
        const modal = bootstrap.Modal.getInstance(modalGlobal) || new bootstrap.Modal(modalGlobal);

        const modalTitulo = document.getElementById('modalTitle');
        const modalBody = document.getElementById('modalBody');
        const btnSave = document.getElementById('modalBtnSave');
            
        modalTitulo.textContent = titulo;
        modalBody.innerHTML = contenido;

        btnSave.textContent = textoBoton;
        btnSave.className = `btn ${claseBoton}`;
        
        btnSave.onclick = () => {
            if (onSubmit) {
                onSubmit();
            }
        };

        modal.show();
    }

function cerrarModal() {
    const modalGlobal = document.getElementById('modalGlobal');
    const modal = bootstrap.Modal.getInstance(modalGlobal) || new bootstrap.Modal(modalGlobal);
    modal.hide();
}
