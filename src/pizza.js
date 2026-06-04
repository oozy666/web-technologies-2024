const FOOD_MENU = {
    "Маргарита": { price: 500, calories: 300 },
    "Пепперони": { price: 800, calories: 400 },
    "Баварская": { price: 700, calories: 450 }
};

const SIZE_METRICS = {
    "Большая": { price: 200, calories: 200 },
    "Маленькая": { cost: 100, price: 100, calories: 100 }
};

const EXTRA_TOPPINGS = {
    "сырный борт": { priceSmall: 150, priceLarge: 300, calories: 50 },
    "сливочная моцарелла": { price: 50, calories: 20 },
    "чедер и пармезан": { priceSmall: 150, priceLarge: 300, calories: 50 }
};

class Pizza {
    constructor() {
        this.pizzaType = null;
        this.size = null;
        this.toppings = [];
    }

    addTopping(topping) {
        const idx = this.toppings.indexOf(topping);
        if (idx === -1) {
            this.toppings.push(topping);
        } else {
            this.toppings.splice(idx, 1);
        }
        updateButton();
    }

    calculatePrice() {
        const base = FOOD_MENU[this.pizzaType]?.price || 0;
        const sizePrice = SIZE_METRICS[this.size]?.price || 0;

        const extras = this.toppings.reduce((total, topping) => {
            const data = EXTRA_TOPPINGS[topping];
            if (data.priceSmall !== undefined) {
                return total + (this.size === "Маленькая" ? data.priceSmall : data.priceLarge);
            }
            return total + data.price;
        }, 0);

        return base + sizePrice + extras;
    }

    calculateCalories() {
        const base = FOOD_MENU[this.pizzaType]?.calories || 0;
        const sizeCcal = SIZE_METRICS[this.size]?.calories || 0;
        const extrasCcal = this.toppings.reduce((total, topping) => {
            return total + (EXTRA_TOPPINGS[topping]?.calories || 0);
        }, 0);

        return base + sizeCcal + extrasCcal;
    }
}

const pizza = new Pizza();

document.querySelectorAll('.pizza-thumb').forEach(item => {
    item.addEventListener('click', () => {
        document.querySelectorAll('.pizza-thumb').forEach(p => p.classList.remove('selected'));
        item.classList.add('selected');
        pizza.pizzaType = item.getAttribute('data-type');
        updateButton();
    });
});

document.querySelector('input[name=size][value="Маленькая"]').checked = true;
pizza.size = "Маленькая";
document.querySelector('input[name=size][value="Маленькая"]').parentElement.classList.add('selected');

document.querySelectorAll('input[name=size]').forEach(radio => {
    radio.addEventListener('change', () => {
        pizza.size = radio.value;
        document.querySelectorAll('.size-toggle-btn').forEach(opt => opt.classList.remove('selected'));
        radio.parentElement.classList.add('selected');
        updateButton();
    });
});

document.querySelectorAll('.extras-thumb').forEach(item => {
    item.addEventListener('click', () => {
        item.classList.toggle('selected');
        pizza.addTopping(item.getAttribute('data-topping'));
        updateButton();
    });
});

function updateButton() {
    const price = pizza.calculatePrice();
    const calories = pizza.calculateCalories();
    document.getElementById('price').textContent = price || '0';
    document.getElementById('calories').textContent = calories || '0';
}

document.getElementById('btnAddToCart').addEventListener('click', () => {
    if (!pizza.pizzaType || !pizza.size) {
        alert("Выберите тип пиццы и размер.");
        return;
    }
    const price = pizza.calculatePrice();
    const calories = pizza.calculateCalories();
    document.getElementById('resultText').innerText = `Заказ оформлен! Стоимость: ${price} рублей, Калорийность: ${calories} Ккалорий`;
});

updateButton();
