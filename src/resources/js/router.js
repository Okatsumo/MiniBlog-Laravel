import VueRouter from 'vue-router';
import Vue from 'vue';

Vue.use(VueRouter)


import index from './views/index';
import Article from './views/Article';
import Articles from "./views/Articles";

const routes = [
    {
        path: '/',
        component: index
    },
    {
        path: '/articles',
        name: 'Articles',
        component: Articles,
    },
    {
        path: '/category/:id',
        name: 'Category',
        component: Articles,
    },
    {
        path: '/article/:id',
        name: 'article',
        component: Article
    },
]


export default new VueRouter({
    mode: 'history',
    routes
})
