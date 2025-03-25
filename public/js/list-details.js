document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('#list-items input').forEach(function(input) {
        input.addEventListener('click', function(event) {
            event.target.removeAttribute('disabled');
            event.target.focus();
        });

        input.addEventListener('blur', function(event) {
            event.target.setAttribute('disabled', 'disabled');
            const itemElement = event.target.closest('.item');
            const itemId = itemElement.querySelector('a').getAttribute('href').split('/').pop();
            const newQuantity = event.target.value;
            const pricePerUnitElement = itemElement.querySelector('.price-per-unit');

            if (pricePerUnitElement) {
                const pricePerUnit = parseFloat(pricePerUnitElement.textContent);

                fetch(`/liste/article/update-quantity/${itemId}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ quantity: newQuantity })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'Quantity updated') {
                            const newPrice = newQuantity * pricePerUnit;
                            itemElement.querySelector('.total-price').textContent = newPrice.toFixed(2) + '€';
                            console.log('Quantity and price updated successfully');

                            // Update the overall total
                            let total = 0;
                            document.querySelectorAll('#list-items .item').forEach(function(item) {
                                const itemQuantity = parseFloat(item.querySelector('input').value);
                                const itemPricePerUnit = parseFloat(item.querySelector('.price-per-unit').textContent);
                                total += itemQuantity * itemPricePerUnit;
                            });
                            document.querySelector('#total p:last-child').textContent = total.toFixed(2) + '€';
                        } else {
                            console.error('Failed to update quantity and price');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            } else {
                console.error('Price per unit element not found');
            }
        });
    });
});