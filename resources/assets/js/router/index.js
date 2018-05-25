import Vue from 'vue';
import VueRouter from 'vue-router';

import Index from '../pages/Index';
import Article from '../pages/Article';
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
            component: Article
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
            component: ArticleContent
        },
        {
            name: 'single2',
            path: '/:name',
            component: SingleContent,
        },
    ]
});