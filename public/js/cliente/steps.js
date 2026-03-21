function goToStep(step) {
    document.querySelectorAll('.step').forEach(s => s.classList.add('d-none'));
    document.getElementById('step' + step).classList.remove('d-none');
}

document.getElementById('reservaModal').addEventListener('show.bs.modal', () => {
    goToStep(1);
});