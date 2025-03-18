document.addEventListener('DOMContentLoaded', () => {
    const openButtons = document.querySelectorAll(".btn-profile-user, .btn-profile-user-nav");
    const closeButton = document.querySelector(".close-btn");
    const profilePopup = document.getElementById("profilePopup");
    const menuBurger = document.querySelector(".menu-burger");
    const headerColumnLinks = document.querySelector(".header-column-links");
    const buttonModify = document.getElementById("modify-button");
    const modifyForm = document.querySelector(".modify-modal-form");
    let isOpen = false;

    openButtons.forEach(button => {
        button.addEventListener('click', () => {
            profilePopup.classList.add("visible");
        });
    });

    if (closeButton) {
        closeButton.addEventListener('click', () => {
            profilePopup.classList.remove("visible");
        });
    }

    if (buttonModify) {
        buttonModify.addEventListener('click', () => {
            modifyForm.classList.add("visible");
        });
    }

    if (menuBurger && headerColumnLinks) {
        menuBurger.addEventListener('click', () => {
            isOpen = !isOpen;
            headerColumnLinks.classList.toggle("visible", isOpen);
        });
    } else {
        console.error("Un ou plusieurs éléments du menu burger sont introuvables.");
    }
});
