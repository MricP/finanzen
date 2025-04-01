document.addEventListener('DOMContentLoaded', function () {
    const openModalBtn = document.querySelector('.add-button-modal');
    const modalOverlay = document.querySelector('.modal-overlay');
    const closeModalBtn = document.querySelector('.close-modal');
    const addArticleBtn = document.querySelector('.add-article-s-btn');

    openModalBtn.addEventListener('click', function () {
        modalOverlay.classList.add('modal-visible');
    });

    closeModalBtn.addEventListener('click', function () {
        modalOverlay.classList.remove('modal-visible');
    });

    modalOverlay.addEventListener('click', function (event) {
        if (event.target === modalOverlay) {
            modalOverlay.classList.remove('modal-visible');
        }
    });

    addArticleBtn.addEventListener('click', function (event) {
        event.preventDefault();

        let articlesToAdd = [];
        document.querySelectorAll('.table-row').forEach(row => {
            let quantityInput = row.querySelector('.quantity-increment');
            let quantity = parseInt(quantityInput.value, 10);
            if (quantity > 0) {
                articlesToAdd.push({
                    id: row.dataset.articleId,
                    quantity: quantity
                });
            }
        });

        if (articlesToAdd.length > 0) {
            // Récupérer l'ID de l'URL
            const url = window.location.href;
            const urlParts = url.split('/');
            const listeId = urlParts[urlParts.length - 1]; // Suppose que l'ID est le dernier segment de l'URL

            fetch(`/liste/article/add/${listeId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ articles: articlesToAdd })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    location.reload();
                } else {
                    alert('Erreur lors de l\'ajout des articles.');
                }
            })
            .catch(error => console.error('Erreur:', error));
        } else {
            alert('Veuillez sélectionner au moins un article.');
        }
    });
});
