const MENU_ITEMS = {
    "Маргарита": { cost: 500, ccal: 300 },
    "Пепперони": { cost: 800, ccal: 400 },
    "Баварская": { cost: 700, ccal: 450 }
};

const SIZE_VALUES = {
    "Большая": { cost: 200, ccal: 200 },
    "Маленькая": { cost: 100, ccal: 100 }
};

const EXTRA_ITEMS = {
    "сливочная моцарелла": { cost: 50, ccal: 20 },
    "сырный борт": { cost_sm: 150, cost_lg: 300, ccal: 50 },
    "чедер и пармезан": { cost_sm: 150, cost_lg: 300, ccal: 50 }
};

class Pizza {
    constructor(pizzaType, size) {
        if (!MENU_ITEMS[pizzaType] || !SIZE_VALUES[size]) {
            throw new Error("Неверные параметры пиццы");
        }
        this.type = pizzaType;
        this.sizeValue = size;
        this.toppingList = [];
    }

    addTopping(topping) {
        if (!EXTRA_ITEMS[topping]) {
            throw new Error("Неверная добавка");
        }
        if (!this.toppingList.includes(topping)) {
            this.toppingList.push(topping);
        }
    }

    removeTopping(topping) {
        const idx = this.toppingList.indexOf(topping);
        if (idx !== -1) {
            this.toppingList.splice(idx, 1);
        }
    }

    getToppings() {
        return this.toppingList;
    }

    getSize() {
        return this.type;
    }

    getStuffing() {
        return this.sizeValue;
    }

    calculatePrice() {
        const baseCost = MENU_ITEMS[this.type].cost;
        const sizeCost = SIZE_VALUES[this.sizeValue].cost;
        let toppingsCost = 0;
        
        for (const top of this.toppingList) {
            const item = EXTRA_ITEMS[top];
            if (top === "сырный борт" || top === "чедер и пармезан") {
                toppingsCost += (this.sizeValue === "Маленькая" ? item.cost_sm : item.cost_lg);
            } else {
                toppingsCost += item.cost;
            }
        }
        return baseCost + sizeCost + toppingsCost;
    }

    calculateCalories() {
        const baseCcal = MENU_ITEMS[this.type].ccal;
        const sizeCcal = SIZE_VALUES[this.sizeValue].ccal;
        let toppingsCcal = 0;

        for (const top of this.toppingList) {
            toppingsCcal += EXTRA_ITEMS[top].ccal;
        }
        return baseCcal + sizeCcal + toppingsCcal;
    }
}

document.getElementById('basePizza').addEventListener('change', () => {
    document.getElementById('sizeContainer').classList.remove('is-hidden');
});

document.getElementById('pizzaSize').addEventListener('change', () => {
    document.getElementById('extrasContainer').classList.remove('is-hidden');
    document.getElementById('btnSubmit').classList.remove('is-hidden');
});

document.getElementById('btnSubmit').addEventListener('click', () => {
    const pizzaType = document.getElementById('basePizza').value;
    const size = document.getElementById('pizzaSize').value;

    if (!pizzaType || !size) {
        alert("Выберите пиццу и размер.");
        return;
    }

    const pizza = new Pizza(pizzaType, size);
    const checkboxes = document.querySelectorAll('#extrasContainer input[type=checkbox]');
    
    checkboxes.forEach(box => {
        if (box.checked) {
            pizza.addTopping(box.value);
        }
    });

    const price = pizza.calculatePrice();
    const calories = pizza.calculateCalories();

    document.getElementById('outputDisplay').innerHTML = `
        <p><strong>Стоимость:</strong> ${price} руб.</p>
        <p><strong>Калорийность:</strong> ${calories} ккал</p>
    `;
});
