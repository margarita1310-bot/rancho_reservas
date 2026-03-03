document.addEventListener('DOMContentLoaded', () => {
    function abrirModal ({
        titulo,
        contenido,
        textoBoton = "Guardar",
        claseBoton = "btn-primary",
        onSubmit })
        
        {
            const modal = document.getElementById('modal-global');
            const modalTitulo = document.getElementById('modal-title');
            const modalBody = document.getElementById('modal-body');
            const modalForm = document.getElementById('modal-form');
            const btnSave = document.getElementById('modal-btn-save');
            const btnCancel = document.getElementById('modal-btn-cancel');
            
            modalTitulo.textContent = titulo;
            modalBody.innerHTML = contenido;

            btnSave.textContent = textoBoton;
            btnSave.className = `btn btn-sm ${claseBoton}`;

            modal.classList.remove('d-none');
        
            btnSave.onclick = () => {
                if (onSubmit) onSubmit();
            };

            btnCancel.onclick = () => {
                modal.classList.add('d-none');
            };
        
            modal.onclick = e => {
                if (e.target === modal) {
                    modal.classList.add('d-none');
                }
            };
        }
        
        window.abrirModal = abrirModal;
    }
);
