document.addEventListener('DOMContentLoaded', function() {
    console.log('toggle-articles.js loaded');
    const articles = document.querySelectorAll('.item');

    articles.forEach(function(article) {
        const itemName = article.querySelector('#item-name');
        if (itemName) {
            itemName.addEventListener('click', function(event) {
                event.stopPropagation(); // Empêche la propagation de l'événement au parent
                const articleId = article.dataset.id;
                const csrfMeta = document.querySelector('meta[name="csrf-token"]');
                const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

                fetch(`/liste_article/toggle/${articleId}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': csrfToken
                    },
                    body: JSON.stringify({ _token: csrfToken })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            console.log('Article toggled successfully');
                            itemName.classList.toggle('item-bought');
                        } else {
                            console.error('Failed to toggle article');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        }
    });
});