// Загрузка корзины из LocalStorage при старте страницы
const savedCart = localStorage.getItem("cart");
let cart = savedCart ? JSON.parse(savedCart) : [];

const products = document.querySelectorAll(".product");
const addButtons = document.querySelectorAll(".add-to-cart");
const cartItems = document.getElementById("cart-items");
const totalElement = document.getElementById("total");
const payButton = document.getElementById("pay-button");
const clearCartButton = document.getElementById("clear-cart");
const categoryFilter = document.getElementById("category-filter");

// Сохранение корзины в LocalStorage
const saveCart = () => {
    localStorage.setItem("cart", JSON.stringify(cart));
};

const calculateTotal = () => {
    let total = 0;
    cart.forEach(item => {
        total += item.price;
    });
    return total;
};

const renderCart = () => {
    cartItems.innerHTML = "";

    if (cart.length === 0) {
        cartItems.innerHTML = "<p>Корзина пуста</p>";
        totalElement.textContent = "Итого: 0 руб.";
        return;
    }

    cart.forEach((item, index) => {
        const cartItem = document.createElement("div");
        cartItem.classList.add("cart-item");

        cartItem.innerHTML = `
            <p><strong>${item.name}</strong> — ${item.price} руб.</p>
            <button class="remove-item" data-index="${index}">Удалить</button>
        `;

        cartItems.appendChild(cartItem);
    });

    totalElement.textContent = "Итого: " + calculateTotal() + " руб.";

    const removeButtons = document.querySelectorAll(".remove-item");
    removeButtons.forEach(button => {
        button.addEventListener("click", () => {
            const index = Number(button.dataset.index);
            cart.splice(index, 1);
            saveCart(); // Сохраняем после удаления
            renderCart();
        });
    });
};

const addToCart = (product) => {
    cart.push(product);
    saveCart(); // Сохраняем после добавления
    renderCart();
};

addButtons.forEach(button => {
    button.addEventListener("click", () => {
        const productCard = button.closest(".product");

        const product = {
            name: productCard.dataset.name,
            price: Number(productCard.dataset.price),
            category: productCard.dataset.category
        };

        addToCart(product);
    });
});

const filterProducts = () => {
    const selectedCategory = categoryFilter.value;

    products.forEach(product => {
        if (selectedCategory === "all" || product.dataset.category === selectedCategory) {
            product.style.display = "block";
        } else {
            product.style.display = "none";
        }
    });
};

categoryFilter.addEventListener("change", filterProducts);

clearCartButton.addEventListener("click", () => {
    cart = [];
    saveCart(); // Сохраняем после очистки
    renderCart();
});

payButton.addEventListener("click", () => {
    if (cart.length === 0) {
        alert("Корзина пуста");
    } else {
        alert("Покупка прошла успешно");
        cart = [];
        saveCart(); // Сохраняем после оплаты
        renderCart();
    }
});

// Отрисовка корзины при загрузке страницы (включая данные из LocalStorage)
renderCart();
