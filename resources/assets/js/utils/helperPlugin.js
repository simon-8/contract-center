export default {
    install (Vue, options) {
        Vue.prototype.imgurl = function (url, size) {
            if (url) {
                return url;
            }
            size = size === undefined ? 60 : parseInt(size);
            return '/images/nopic_' + size + '.png';
        };
        Vue.prototype.seoInfo = function (title, description = '') {
            document.title = title;
            //document.meta[name=description] = description;
        };
        Vue.prototype.getAPI = (name, params = {}) => {
            var api = window.axios.defaults.api[name] ? window.axios.defaults.api[name] : null;
            if (api === null) throw Error('API not Found!');
            if (arguments.length > 1) {
                for (i = 1; i < arguments.length; i++) {
                    api = api.replace('{param}', arguments[i]);
                }
            }
            return api;
        };
        //Vue.prototype.getCache = (name) => {
        //    return this.$store.state[name];
        //};
        //Vue.prototype.setCache = (name, data) => {
        //    this.$store.state[name] = data;
        //    return true;
        //};
        Vue.prototype.articleUrl = (id) => {
            return '/article/' + id + '.html';
        };

    }
};