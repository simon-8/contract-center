import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const store = {
    state: {
        count: 0,
        indexArticle: [] // 存储首页文章列表数据
    },
    mutations: {
        increment(state) {
            state.count++;
        }
    }
};
export default store;