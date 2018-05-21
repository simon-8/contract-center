import Vue from 'vue';
import VueRouter from 'vue-router';
import IndexComponent from '../components/IndexComponent';
import ArticleComponent from '../components/ArticleComponent';
import WebpageComponent from '../components/WebpageComponent';
import ContentComponent from '../components/ContentComponent';

Vue.use(VueRouter);

export default new VueRouter({
    saveScrollPosition: true,
    mode: 'history',
    routes: [
        {
            name: 'index',
            path: '/',
            component: IndexComponent
        },
        {
            name: 'article',
            path: '/article',
            component: ArticleComponent
        },
        {
            name: 'webpage',
            path: '/webpage',
            component: WebpageComponent
        },
        {
            name: 'content',
            path: '/content/:id',
            component: ContentComponent
        }
    ]
});