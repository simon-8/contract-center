export default {
    state: {
        catid: 0,
        articles: [],
        tags: []
    },
    mutations: {
        setArticles (state, articles) {
            state.articles = articles;
        },
        setCatid (state, catid) {
            state.catid = catid;
        },
        setTags (state, tags) {
            state.tags = tags;
        }
    }
}