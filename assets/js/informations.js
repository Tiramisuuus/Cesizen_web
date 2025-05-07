// public/js/informations.js
document.addEventListener('DOMContentLoaded', () => {
    const openButtons = document.querySelectorAll('[data-modal]');
    const closeButtons = document.querySelectorAll('.modal-close');

    openButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-modal');
            document.getElementById(id).style.display = 'flex';
        });
    });

    closeButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-modal');
            document.getElementById(id).style.display = 'none';
        });
    });

    // Fermer si clic hors du contenu
    document.querySelectorAll('.modal').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
});
