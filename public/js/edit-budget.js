document.addEventListener('DOMContentLoaded', function() {
    const input = document.querySelector('.secondary-statistic-price-input')
    input.addEventListener('keydown', function(event) {
        if(event.key === 'Enter'){
            if (input.value) {
                let newBudget = input.value;
                newBudget = parseFloat(newBudget);
                fetch(`/budget/update`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ monthBudget: newBudget })
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data)
                        if (data.status === 'Budget updated') {
                            console.log('Budget updated successfully');
                            input.value = data.monthBudget
                        } else {
                            console.error('Failed to update Budget');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            } else {
                console.error('Price per unit element not found');
            }
            event.preventDefault();
        }
    });
});
