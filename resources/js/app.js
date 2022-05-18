require('./bootstrap');

import { createApp } from 'vue'
import Articles from './components/Articles'
import Navbar from './components/Navbar'
const app = createApp({})
app.component(
    'articles', 
    Articles
);
app.component(
    'navbar', 
    Navbar
);
app.mount('#app')
