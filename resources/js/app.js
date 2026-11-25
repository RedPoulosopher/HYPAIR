import { createApp } from 'vue';

import Home from './components/Home.vue';
import Dashbord from './components/Dashbord.vue';

let page;

switch (window.location.pathname) {
    case '/telethon/tele':
        page = Dashbord;
        break;

    default:
        page = Home;
}

const appElement = document.getElementById('app');

const bladeData = JSON.parse(appElement.dataset.blade || '{}');
createApp(page, {bladeData}).mount('#app');
