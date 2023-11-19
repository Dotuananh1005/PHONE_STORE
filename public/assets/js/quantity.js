// public/js/quantity.js (đường dẫn public để được truy cập từ bên ngoài)
document.addEventListener("DOMContentLoaded", function() {
    const quantityElements = document.querySelectorAll('.quantity');

    quantityElements.forEach(quantityElement => {
        const minusBtn = quantityElement.querySelector('.btn-minus');
        const plusBtn = quantityElement.querySelector('.btn-plus');
        const quantityInput = quantityElement.querySelector('.quantity-input');

        minusBtn.addEventListener('click', () => {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });

        plusBtn.addEventListener('click', () => {
            let currentValue = parseInt(quantityInput.value);
            quantityInput.value = currentValue + 1;
        });
    });
});
