import todosService from "../services/todos.js";
import loading from "../services/loading.js";
import Auth from "../services/auth.js";
import location from "../services/location.js";

const renderTodos = (todos) => {
    const todoList = document.getElementById('todo-list');
    todoList.innerHTML = '';

    todos.forEach(todo => {
        const item = document.createElement('li');
        item.className = 'todo-item';
        if (todo.completed) {
            item.classList.add('completed');
        }
        item.innerHTML = `
            <div class="todo-item-content">
                <input type="checkbox" data-id="${todo.id}" ${todo.completed ? 'checked' : ''} class="todo-checkbox">
                <span class="todo-text">${todo.description}</span>
            </div>
            <button class="delete-button todo-delete-btn" data-id="${todo.id}">Удалить</button>
        `;
        todoList.appendChild(item);
    });
};

const init = async () => {
    const { ok: isLogged } = await Auth.me();

    if (!isLogged) {
        return location.login();
    } else {
        loading.stop();
    }

    loading.start();
    try {
        const todos = await todosService.getAll();
        renderTodos(todos);
    } catch (err) {
        console.error(err);
    } finally {
        loading.stop();
    }

    const submitBtn = document.getElementById('todo-submit');
    const inputField = document.getElementById('todo-input');

    submitBtn.addEventListener('click', async (e) => {
        e.preventDefault();
        const desc = inputField.value.trim();
        if (!desc) {
            return;
        }

        loading.start();
        try {
            await todosService.create(desc);
            inputField.value = '';
            const todos = await todosService.getAll();
            renderTodos(todos);
        } catch (err) {
            console.error(err);
        } finally {
            loading.stop();
        }
    });

    const todoList = document.getElementById('todo-list');

    todoList.addEventListener('click', async (e) => {
        if (e.target.type === 'checkbox') {
            e.preventDefault();
            const todoId = e.target.dataset.id;
            const completed = !e.target.checked;

            loading.start();
            try {
                await todosService.updateStatus(todoId, completed);
                const todos = await todosService.getAll();
                renderTodos(todos);
            } catch (err) {
                console.error(err);
            } finally {
                loading.stop();
            }
        }
    });

    todoList.addEventListener('click', async (e) => {
        if (e.target.classList.contains('delete-button')) {
            e.preventDefault();
            const todoId = e.target.dataset.id;

            loading.start();
            try {
                await todosService.delete(todoId);
                const todos = await todosService.getAll();
                renderTodos(todos);
            } catch (err) {
                console.error(err);
            } finally {
                loading.stop();
            }
        }
    });
};

if (document.readyState === 'loading') {
    document.addEventListener("DOMContentLoaded", init);
} else {
    init();
}
