//importo vue e router
import Vue from "vue";
import VueRouter from "vue-router";
Vue.use(VueRouter);

// qui prima importo il componente che farà da "vista" e poi ne definisco la rotta dentro una istanza di VUeRouter
import Home from './pages/Home';
import About from './pages/About';
import Contact from './pages/Contact';
import Blog from './pages/Blog'
// importo pagina singolo post
import SinglePost from './pages/SinglePost'

const routes = new VueRouter({
    //mode history per evitare obbligo di #
    mode: 'history',
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
            path : '/blog',
            name: 'blog',
            component: Blog,
        },
        //path per singolo post con slug dinamico
        {
            path: '/blog/:slug',
            name: 'single-post',
            component: SinglePost,
        }

    ]
});

// devo esportare la costante
export default routes;
