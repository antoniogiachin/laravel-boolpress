window.Vue = require('vue');
window.axios = require('axios');
// gestisce csrf in front
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


// importo il componente vue
import Vue from 'vue';
import App from './components/App';
//importo file di router.js
import router from './router';



// istanzio nuovo Vue
const app = new Vue ({
    // circoscrivo area azione vue
    el: '#root',
    render: h => h(App), // mostra App all'avvio di Vue
    // nella app renderizzo anche il router
    router
})
