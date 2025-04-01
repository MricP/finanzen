document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-form').forEach(function(form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            const url = this.action;
            const csrfToken = this.querySelector('input[name="_token"]').value;
            const item = this.closest('.item');

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: '_token=' + encodeURIComponent(csrfToken)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    item.remove();
                    // Optionnel : recalculer le total ici si nécessaire
                } else {
                    alert('Erreur lors de la suppression de l\'article.');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors de la suppression.');
            });
        });
    });
});