//importo vue e router
import Vue from "vue";
import VueRouter from "vue-router";
Vue.use(VueRouter);

// qui prima importo il componente che farà da "vista" e poi ne definisco la rotta dentro una istanza di VUeRouter
import Home from './pages/Home';
import About from './pages/About';
import Contact from './pages/Contact';
import Posts from './pages/Posts'

const routes = new VueRouter({
    //rotte
    routes: [
        {
            // la rotta è un oggetto con 
            // uri
            path: '/',
            // nome rotta
            name: 'home',
            // componente da mostrare
            component: Home,
        },

        {
            path : '/chi-siamo',
            name: 'about',
            component: About,
        },
        {
            path: '/contatti',
            name: 'contact',
            component: Contact,
        },
        {
            path : '/posts',
            name: 'posts',
            component: Posts,
        }

    ]
});

// devo esportare la costante
export default routes;