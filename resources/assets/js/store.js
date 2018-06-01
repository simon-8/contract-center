import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

import article_store from './stores/article.js';

export default new Vuex.Store({
    modules: {
        article: article_store
    }
})