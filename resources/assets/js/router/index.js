import Vue from 'vue';
import VueRouter from 'vue-router';

import Index from '../pages/Index';
import Article from '../pages/Article';
import Single from '../pages/Single';
import Content from '../pages/Content';

Vue.use(VueRouter);

export default new VueRouter({
    saveScrollPosition: true,
    mode: 'history',
    routes: [
        {
            name: 'index',
            path: '/',
            component: Index
        },
        {
            //name: 'index',
            path: '/:name',
            component: Single,
        },
        {
            name: 'article',
            path: '/article',
            component: Article
        },
        {
            name: 'single',
            path: '/single/:id',
            component: Single
        },
        {
            name: 'content',
            path: '/content/:id',
            component: Content
        }
    ]
});