import api from "./api.js";

const todosService = {
    async getAll() {
        const response = await api('/todo');
        return response.data;
    },

    async create(description) {
        return await api('/todo', {
            method: 'POST',
            body: JSON.stringify({ description })
        });
    },

    async updateStatus(todoId, completed) {
        return await api(`/todo/${todoId}`, {
            method: 'PUT',
            body: JSON.stringify({ completed })
        });
    },

    async delete(todoId) {
        return await api(`/todo/${todoId}`, {
            method: 'DELETE'
        });
    }
};

export default todosService;
