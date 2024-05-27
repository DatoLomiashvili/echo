import './bootstrap';
import { createApp } from 'vue';

import TaskList from './components/TaskList.vue'
import Webcam from "./components/Webcam.vue";

const app = createApp({});

app.component('webcam-component', Webcam);
app.component('task-list', TaskList);

app.mount('#app');

