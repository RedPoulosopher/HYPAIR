import { createApp } from 'vue';

import Home from './components/Home.vue';
import Don from './components/Don.vue';

let page;

switch (window.location.pathname) {

    case '/telethon/don':
        page = Don;
        break;

    default:
        page = Home;
}

createApp(page).mount('#app');