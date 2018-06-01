<template>
    <div>
        <div class="articles" v-loading="loading">
            <article class="row" v-for="item of articles" :key="item.id">
                <div class="col-xs-12 col-md-3 hidden-xs article-thumb">
                    <img :src="imgurl(item.thumb)" class="lazy" alt="" width="100%">
                </div>
                <div class="col-xs-12 col-md-9 article-info">
                    <h4>
                        <router-link :to="articleUrl(item.id)">{{ item.title }}</router-link>
                    </h4>

                    <p class="introduce text-ellipsis" v-html="item.introduce"></p>
                    <p class="meta">
                        <span class="meta-info">
                            <i class="glyphicon glyphicon-time"></i>
                            {{ item.created_at }}
                        </span>
                        <span class="meta-info">
                            <i class="glyphicon glyphicon-thumbs-up"></i>
                            {{ item.zan }}
                        </span>
                        <span class="meta-info">
                            <i class="glyphicon glyphicon-comment"></i>
                            {{ item.comment }}
                        </span>
                    </p>
                    <!--<div class="col-xs-6 text-left">-->
                        <!--<span class="meta-info" v-if="item.tags.length">-->
                            <!--<i class="glyphicon glyphicon-tags"></i>-->
                            <!--<router-link :to="articleUrl(item.id)" v-for="tag of item.tags" :key="tag.id">-->
                                <!--<el-tag size="small">{{ tag.name }}</el-tag>-->
                            <!--</router-link>-->
                        <!--</span>-->
                    <!--</div>-->
                </div>
            </article>
            <p class="text-center" v-if="articles.length < 1">暂无数据</p>
        </div>

        <div class="clear">&nbsp;</div>

        <div class="text-center" v-if="articles.length">
            <el-pagination
                    background
                    layout="prev, pager, next"
                    :page-size="pageSize"
                    :total="total"
                    :current-page="currentPage"
                    @current-change="getData"
            >
            </el-pagination>
        </div>

    </div>
</template>

<style scoped>

    article {
        border-bottom: 1px solid #eee;
        padding: 12px 0;
        margin: 10px 0;
        position: relative;
    }
    article h4 {
        margin:0;
        padding: 0;
    }
    article .article-thumb img {
        width: 100%;
        border: 1px solid #eee;
    }
    article .article-info {
        position: absolute;
        height: calc(100% - 20px);
        right: 0;
    }
    article .article-info p {
        margin: 5px 0 7px 0;
    }
    article .article-info .meta {
        position: absolute;
        bottom: 0;
        margin: 0;
    }
    article .article-info .meta-info {
        margin-right: 10px;
    }
    article .el-tag {
        margin-left: 10px;
    }
    @media screen and (max-width: 768px) {
        article .article-info {
            position: relative;
        }
        article .article-info .meta {
            position: relative;
        }
    }

</style>

<script>
    export default {
        name: "Articles",
        data () {
            return {
                catid: 0,
                name: null,
                articles: [],
                currentPage: 1,
                pageSize: 10,
                total: 0,
                loading: false
            }
        },
        computed: {
            tags () {

            }
        },
        methods: {
            getCache (name) {
                return this.$store.state.article[name];
            },
            setCache (name, data) {
                this.$store.commit('setArticles', data);
                return true;
            },
            getTagData () {
                axios.get(this.getAPI('tag')).then((res) => {
                    this.tags = res.data;
                    this.setCache('tags', this.tags);
                }).catch((res) => {
                    this.$message.error('获取标签出错');
                    console.log(res);
                })
            },
            getTagid () {
                let name = this.$route.params.name;
                let tagsCache = this.getCache('tags') || [];
                let tagid = 0;
                if (tagsCache && tagsCache.length) {
                    tagsCache.forEach((val, index) => {
                        if (val.name === name) {
                            tagid = val.id;
                        }
                    });
                }
                return tagid;
            },
            requestData (requestUrl) {
                axios.get(requestUrl).then((res) => {
                    let data = res.data;
                    this.articles = data.data;
                    this.total = data.total;
                    this.loading = false;
                    //this.setCache('', this.articles);
                }).catch((res) => {
                    console.log(res);
                });
            },
            getData (page = 1) {
                this.currentPage = page;
                this.loading = true;
                this.articles = [];

                let params = '?page=' + this.currentPage + '&pagesize=' + this.pageSize;
                let url = this.getAPI('article');
                if (this.$route.params.catid) {
                    params += '&catid=' + this.$route.params.catid;
                } else if (this.$route.params.name) {
                    let tagid = this.getTagid();
                    url = this.getAPI('tagArticle') + tagid;
                }
                this.requestData(url + params);

            }
        },
        watch: {
            '$route' (to, from) {
                if (to.params.catid && to.params.catid !== this.catid) {
                    this.catid = this.$route.params.catid;
                }
                if (to.params.name && to.params.name !== this.name) {
                    this.name = this.$route.params.name;
                }
                this.getData();
            }
        },
        mounted () {
            console.log('this is articles component');
            this.getData();
        },
    }
</script>