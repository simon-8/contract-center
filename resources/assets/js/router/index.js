import Vue from 'vue';
import VueRouter from 'vue-router';

import Index from '../pages/Index';
//import Tag from '../pages/Tag';
import SingleContent from '../pages/SingleContent';
import ArticleContent from '../pages/ArticleContent';

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
            name: 'category',
            path: '/category/:catid(\\d+)',
            component: Index
        },
        {
            name: 'article',
            path: '/article/:id(\\d+).html',
            component: ArticleContent
        },
        {
            name: 'single',
            path: '/single/:id(\\d+).html',
            component: SingleContent
        },
        {
            name: 'tag',
            path: '/tag/:name',
            component: Index
        },
        {
            name: 'single2',
            path: '/:name',
            component: SingleContent,
        },
    ]
});