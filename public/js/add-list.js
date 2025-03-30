document.addEventListener("DOMContentLoaded", () => {
    const modal = document.querySelector(".modal-overlay");
    const closeModal = document.querySelector(".close-modal");
    const openModalButton = document.querySelector(".add-button");

    if (openModalButton) {
        openModalButton.addEventListener("click", (event) => {
            event.preventDefault();
            modal.classList.add("visible");
        });
    } else {
        console.error("Le bouton d'ouverture de la modal est introuvable.");
    }

    if (closeModal) {
        closeModal.addEventListener("click", () => {
            modal.classList.remove("visible");
        });
    } else {
        console.error("Le bouton de fermeture de la modal est introuvable.");
    }

    modal.addEventListener("click", (event) => {
        if (event.target === modal) {
            modal.classList.remove("visible");
        }
    });
});
