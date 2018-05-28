
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
Vue.use(ElementUI);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import App from './App.vue';
import router from './router/index.js';
import store from './store.js';
import helperPlugin from './utils/helperPlugin.js';

// 注册全局插件
Vue.use(helperPlugin);

// 注册全局组件
Vue.component('Tag', require('./components/TagComponent'));
Vue.component('Project', require('./components/ProjectComponent'));

//router.beforeEach((to, from, next) => {
//    /* 路由发生变化修改页面title */
//    if (to.meta.title) {
//        document.title = to.meta.title;
//    }
//    next();
//});

const app = new Vue({
    el: '#app',
    router,
    store,
    template: '<App/>',
    components: { App }
});
// 载入App组件并替换#app为App标签
// 相当于 app.js中  Vue.component('App', require('./components/App.vue'));
// 然后vue页面中 <div id="app"><App></App></div>