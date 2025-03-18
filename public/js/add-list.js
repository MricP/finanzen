document.addEventListener("DOMContentLoaded", () => {
    console.log("connection add-list");

    const addListButton = document.querySelector(".add-list-link");
    const popup = document.getElementById("list-popup"); // div exterieure
    const popupContainer = document.querySelector("div.container"); // div interieure
    let isOpen = false;
    console.log(addListButton);
    console.log(popup);
    console.log(popupContainer);

    if (addListButton && popup) {
        addListButton.addEventListener("click", (event) => {
            event.preventDefault();
            popup.classList.add("visible");
            isOpen = true;
            if (isOpen) {
                fetch('/liste/new')
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        const header = doc.querySelector('header');
                        const footer = doc.querySelector('footer');
                        if (header) header.remove();
                        if (footer) footer.remove();
                        console.log(doc.body.innerHTML);

                        popupContainer.innerHTML = doc.body.innerHTML;
                    })
                    .catch(error => {
                        console.error('Error fetching the form:', error);
                    });
            }
        });
    } else {
        console.error("Un ou plusieurs éléments n'ont pas été trouvés dans le DOM.");
    }
});