document.addEventListener("DOMContentLoaded", () => {
    const openButtons = document.querySelectorAll(".btn-profile-user, .btn-profile-user-nav");
    const closeButton = document.querySelector(".close-btn");
    const profilePopup = document.getElementById("profilePopup");
    const menuBurger = document.querySelector(".menu-burger");
    const headerColumnLinks = document.querySelector(".header-column-links");
    const buttonModify = document.getElementById("modify-button");
    const modifyForm = document.querySelector(".modify-modal-form");
    const errorMessage = document.querySelector(".error-message");
    const profileImageInside = document.querySelector(".default-user-icon-inside");
    const profileImageButtons = document.querySelectorAll(".btn-profile-user img, .btn-profile-user-nav img");
    const fileInput = document.getElementById("profile-picture-input");
    let isOpen = false;
    let isFormOpen = false;

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

    if (fileInput && profileImageInside) {
        fileInput.addEventListener("change", async (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const newImageSrc = e.target.result;
                    profileImageInside.src = newImageSrc;
                    profileImageInside.classList.add("default-user-icon-inside");
                    profileImageButtons.forEach(img => {
                        img.src = newImageSrc;
                        img.classList.add("default-user-icon");
                    });
                };
                reader.readAsDataURL(file);

                const formData = new FormData();
                formData.append("profile-picture", file);

                try {
                    const response = await fetch("/upload-profile-picture", {
                        method: "POST",
                        body: formData,
                    });

                    const result = await response.json();

                    if (!response.ok) {
                        throw new Error(result.error || "Erreur lors du téléversement");
                    }
                } catch (error) {
                    console.error("Erreur :", error);
                    errorMessage.textContent = error.message;
                }
            }
        });
    }

    if (menuBurger && headerColumnLinks) {
        menuBurger.addEventListener('click', () => {
            isOpen = !isOpen;
            headerColumnLinks.classList.toggle("visible", isOpen);
        });
    }

    if (buttonModify) {
        buttonModify.addEventListener('click', async () => {
            if (!isFormOpen) {
                modifyForm.classList.add("visible");
                isFormOpen = true;
                try {
                    const response = await fetch("/get-infos-user");
                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.error || "Erreur lors de la récupération des informations");
                    }

                    document.getElementById("pseudo-input").value = data.pseudo || "";
                    document.getElementById("email-input").value = data.email || "";
                } catch (error) {
                    console.error("Erreur :", error);
                    errorMessage.textContent = error.message;
                }
            } else {
                modifyForm.classList.remove("visible");
                isFormOpen = false;
            }
        });
    }

    if (modifyForm) {
        modifyForm.addEventListener("submit", async (event) => {
            event.preventDefault();

            const formData = new FormData(modifyForm);
            const data = {
                pseudo: formData.get("pseudo"),
                oldPassword: formData.get("old-password"),
                newPassword: formData.get("new-password"),
            };

            try {
                const response = await fetch("/change-infos-user", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(data),
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.error || "Erreur lors de la modification");
                }

                alert("Informations mises à jour avec succès");
                profilePopup.classList.remove("visible");
                isFormOpen = false;
            } catch (error) {
                console.error("Erreur :", error);
                errorMessage.textContent = error.message;
            }
        });
    }
});
