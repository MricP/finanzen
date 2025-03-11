document.addEventListener('DOMContentLoaded', () => {
    console.log("connection header");

    const openButton = document.querySelector(".btn-profile-user");
    const closeButton = document.querySelector(".close-btn");
    const profilePopup = document.getElementById("profilePopup");

    if (openButton && closeButton && profilePopup) {
        openButton.addEventListener('click', () => {
            profilePopup.classList.add("visible");
        });

        closeButton.addEventListener('click', () => {
            profilePopup.classList.remove("visible");
        });
    } else {
        console.error("Un ou plusieurs éléments n'ont pas été trouvés dans le DOM.");
    }
});
