<template>
    <div class="task-list">
        <h1>{{ this.project.title }}</h1>
        <form @submit.prevent="addTask">
            <div>
                <input v-model="newTask" placeholder="Enter task" @keydown="tapParticipants" required/>
            </div>
            <button type="submit">Add Task</button>
        </form>
        <span v-if="activeParticipant" v-text="activeParticipant.name + ' is typing...'"></span>
        <ul>
            <li v-for="task in tasks" :key="task.id">
                {{ task.body }}
                <button @click="deleteTask(task.id)" class="delete-button">Delete</button>
            </li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: ['project'],
    data() {
        return {
            newTask: '',
            tasks: [],
            activeParticipant: false,
            typingTimer: false,
        };
    },

    computed: {
        channel() {
            return window.Echo.private(`tasks.${this.project.id}`);
        }
    },

    created() {
        this.getTasks();

        this.channel.listen('TaskCreated', e => {
            this.tasks.unshift(e.task);
        }).listenForWhisper("typing", this.flashActiveParticipant)
            .listenForWhisper("stoppedTyping", e => {
            this.activeParticipant = false;
        });

        this.channel.listen('TaskDeleted', e => {
            this.tasks = this.tasks.filter(task => task.id !== e.task.id);
        });

    },


    methods: {
        flashActiveParticipant(e) {
            this.activeParticipant = e;

            if (this.typingTimer) {
                clearTimeout(this.typingTimer);
            }

            this.typingTimer = setTimeout(() => this.activeParticipant = false, 3000)
        },
        tapParticipants() {
            this.channel.whisper('typing', {
                    name: window.App.user.name,
                });
        },

        async getTasks() {
            const response = await axios.get(`/api/projects/${this.project.id}`);
            this.tasks = response.data;
        },
        async addTask() {
            const response = await axios.post(`/api/projects/${this.project.id}/tasks`, { body: this.newTask });
            this.tasks.unshift(response.data);
            this.newTask = '';

            this.channel.whisper('stoppedTyping', {});
        },
        async deleteTask(taskId) {
            if (!confirm('Are you sure you want to delete this task?')) return;
            await axios.delete(`/api/projects/tasks/${taskId}`);
            this.tasks = this.tasks.filter(task => task.id !== taskId)
        }
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
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.delete-button {
    background: #dc3545;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    padding: 0.25rem 0.5rem;
}
</style>
