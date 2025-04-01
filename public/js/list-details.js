document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('#list-items input[type="number"]').forEach(function(input) {
        input.addEventListener('blur', function(event) {
            const itemElement = this.closest('.item');
            const itemId = itemElement.dataset.id;
            const newQuantity = parseInt(this.value) || 0;
            const pricePerUnitElement = itemElement.querySelector('.price-per-unit');
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '';

            if (pricePerUnitElement) {
                const pricePerUnit = parseFloat(pricePerUnitElement.textContent);

                fetch(`/liste/article/update-quantity/${itemId}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': csrfToken
                    },
                    body: JSON.stringify({
                        quantity: newQuantity,
                        _token: csrfToken
                    })
                })
                .then(response => response.json())
                .then(data => {
                    data.oldQuantity = this.defaultValue;
                    console.log('Old Quantity:', data.oldQuantity);
                    console.log("status : " + data.status)
                    if (data.status === 'Quantity updated') {
                        const newPrice = newQuantity * pricePerUnit;
                        itemElement.querySelector('.total-price').textContent = newPrice.toFixed(2) + '€';
                        this.defaultValue = newQuantity;
                        console.log('Quantity and price updated successfully');

                        let total = 0;
                        document.querySelectorAll('#list-items .item').forEach(function(item) {
                            const itemQuantityInput = item.querySelector('input[type="number"]');
                            const itemPricePerUnitElement = item.querySelector('.price-per-unit');
                            if (itemQuantityInput && itemPricePerUnitElement) {
                                const itemQuantity = parseInt(itemQuantityInput.value) || 0;
                                const itemPricePerUnit = parseFloat(itemPricePerUnitElement.textContent) || 0;
                                total += itemQuantity * itemPricePerUnit;
                            }
                        });

                        document.querySelector('#total p:last-child').textContent = total.toFixed(2) + '€';
                    } else {
                        console.error('Failed to update quantity and price');
                        this.value = data.oldQuantity || this.defaultValue;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.value = this.defaultValue;
                });
            } else {
                console.error('Price per unit element not found');
            }
        });
    });
});