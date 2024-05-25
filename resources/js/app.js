import './bootstrap';

import { createApp } from 'vue'
import TaskList from './components/TaskList.vue'

createApp({})
    .component('TaskList', TaskList)
    .mount('#app')
