document.addEventListener("DOMContentLoaded", () => {
    console.log("connection add-list");

    const addListButton = document.querySelector(".add-list-link");
    const popup = document.getElementById("list-popup"); // div exterieure
    const popupContainer = document.querySelector("div.container"); // div interieure

    if (addListButton && popup) {
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
        console.error("Un ou plusieurs éléments n'ont pas été trouvés dans le DOM.");
    }
});