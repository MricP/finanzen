document.addEventListener('DOMContentLoaded', function() {
    console.log('toggle-articles.js loaded');
    const articles = document.querySelectorAll('.item');
    console.log(articles);

    articles.forEach(function(article) {
        article.addEventListener('click', function() {
            const articleId = this.dataset.id;
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
                        const itemName = this.querySelector('#item-name');
                        itemName.classList.toggle('item-bought');
                    } else {
                        console.error('Failed to toggle article');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
});