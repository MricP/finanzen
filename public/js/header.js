document.addEventListener('DOMContentLoaded', () => {
    console.log("connection header");

    const openButton = document.querySelector(".btn-profile-user");
    const closeButton = document.querySelector(".close-btn");
    const profilePopup = document.getElementById("profilePopup");
    const menuBurger = document.querySelector(".menu-burger");
    const headerColumnLinks = document.querySelector(".header-column-links");
    let isOpen = false;

    if (openButton && closeButton && profilePopup && menuBurger) {
        openButton.addEventListener('click', () => {
            console.log("vvvved")
            profilePopup.classList.add("visible");
        });

        closeButton.addEventListener('click', () => {
            profilePopup.classList.remove("visible");
        });

        menuBurger.addEventListener('click', () => {
            isOpen = !isOpen;
            if (isOpen) {
                headerColumnLinks.classList.add("visible");
            } else {
                headerColumnLinks.classList.remove("visible");
            }
        });
    } else {
        console.error("Un ou plusieurs éléments n'ont pas été trouvés dans le DOM.");
    }
});


