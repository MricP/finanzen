document.addEventListener('DOMContentLoaded', function() {
    const openModalBtn = document.querySelector('.add-button');
    const modalOverlay = document.querySelector('.modal-overlay');
    const closeModalBtn = document.querySelector('.close-modal');

    openModalBtn.addEventListener('click', function() {
        modalOverlay.classList.add('modal-visible');
    });

    closeModalBtn.addEventListener('click', function() {
        modalOverlay.classList.remove('modal-visible');
    });

    modalOverlay.addEventListener('click', function(event) {
        if (event.target === modalOverlay) {
            modalOverlay.classList.remove('modal-visible');
        }
    });
});
