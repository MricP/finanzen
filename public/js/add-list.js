document.addEventListener("DOMContentLoaded", () => {
    console.log("connection add-list");

    const addListButton = document.querySelector(".add-list-link");
    const popup = document.getElementById("list-popup");
    const popupContainer = document.querySelector("div.liste-add-container");
    const closeBtn = document.querySelector(".close-add-list");

    if (closeBtn) {
        closeBtn.addEventListener("click", () => {
            popup.classList.remove("visible");
        });
    }

    if (addListButton && popup && popupContainer) {
        addListButton.addEventListener("click", (event) => {
            event.preventDefault();
            popup.classList.add("visible");

            fetch('/liste/new')
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    popupContainer.innerHTML = doc.body.innerHTML;
                })
                .catch(error => {
                    console.error('Error fetching the form:', error);
                });
        });
    } else {
        console.error("One or more elements were not found in the DOM.");
    }
});
