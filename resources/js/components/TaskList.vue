<template>
    <div class="task-list">
        <h1>Task List</h1>
        <form @submit.prevent="addTask">
            <input v-model="newTask" placeholder="Enter task" required />
            <button type="submit">Add Task</button>
        </form>
        <ul>
            <li v-for="task in tasks" :key="task.id">
                {{ task.body }}
            </li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            newTask: '',
            tasks: [],
        };
    },
    created() {
        this.getTasks();

        window.Echo.channel('tasks').listen('TaskCreated', e => {
            this.tasks.unshift(e.task)
        })
    },
    methods: {
        async getTasks() {
            const response = await axios.get('/tasks');
            this.tasks = response.data;
        },
        async addTask() {
            if (this.newTask.trim() === '') return;
            const response = await axios.post('/tasks', { body: this.newTask });
            this.tasks.unshift(response.data);
            this.newTask = '';
        },
    },
};
</script>

<style scoped>
.task-list {
    max-width: 600px;
    margin: 0 auto;
    padding: 1rem;
    background: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
.task-list h1 {
    text-align: center;
    margin-bottom: 1rem;
}
.task-list form {
    display: flex;
    justify-content: space-between;
}
.task-list input {
    flex: 1;
    margin-right: 0.5rem;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
}
.task-list button {
    padding: 0.5rem 1rem;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
.task-list ul {
    list-style: none;
    padding: 0;
    margin-top: 1rem;
}
.task-list li {
    padding: 0.5rem;
    border-bottom: 1px solid #ddd;
}
</style>