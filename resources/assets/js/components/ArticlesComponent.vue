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
                            <i class="glyphicon glyphicon-tags"></i>
                             {{ item.category.name }}
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
                </div>
            </article>
            <!--<el-row v-for="item of articles" tag="article" :gutter="10" :key="item.id">-->
                <!--<el-col :span="6" class="article-thumb">-->
                    <!--<img :src="imgurl(item.thumb)" class="lazy" alt="" width="100%">-->
                <!--</el-col>-->

                <!--<el-col :span="18" class="article-info">-->
                    <!--<h4>-->
                        <!--<router-link :to="articleUrl(item.id)">{{ item.title }}</router-link>-->
                    <!--</h4>-->

                    <!--<p class="introduce" v-html="item.introduce"></p>-->
                    <!--<p class="meta">-->
                        <!--<span class="meta-info">-->
                            <!--<i class="glyphicon glyphicon-time"></i>-->
                            <!--{{ item.created_at }}-->
                        <!--</span>-->
                        <!--<span class="meta-info">-->
                            <!--<i class="glyphicon glyphicon-tags"></i>-->
                             <!--{{ item.category.name }}-->
                        <!--</span>-->
                        <!--<span class="meta-info">-->
                            <!--<i class="glyphicon glyphicon-thumbs-up"></i>-->
                            <!--{{ item.zan }}-->
                        <!--</span>-->
                        <!--<span class="meta-info">-->
                            <!--<i class="glyphicon glyphicon-comment"></i>-->
                            <!--{{ item.comment }}-->
                        <!--</span>-->
                    <!--</p>-->
                <!--</el-col>-->
            <!--</el-row>-->
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
                articles: [],
                currentPage: 1,
                pageSize: 10,
                total: 0,
                loading: false
            }
        },
        methods: {
            getData (page = 1) {
                //if (page > 1) {
                //    let cacheData = this.getCache('indexCache');
                //    if (cacheData && cacheData.data.length && cacheData.current_page === page) {
                //        this.articles = cacheData.data;
                //        this.total = cacheData.total;
                //        this.currentPage = cacheData.current_page;
                //        return;
                //    }
                //}
                this.currentPage = page;
                this.loading = true;
                this.articles = [];

                axios.get(this.getAPI('article') + '?catid='+this.catid+'&page='+ page+'&pagesize='+this.pageSize).then((res) => {
                    let data = res.data;
                    this.articles = data.data;
                    this.total = data.total;
                    this.loading = false;
                }).catch((res) => {
                    console.log(res);
                });
            }
        },
        watch: {
            '$route' (to, from) {
                console.log('this is component');
                console.log(this.$route.params.catid);
                if (to.params.catid !== this.catid) {
                    this.catid = isNaN(this.$route.params.catid) ? 0 : this.$route.params.catid;
                    this.getData();
                }
            },
            items (newValue, oldValue) {
                console.log(newValue);
            }
        },
        mounted () {
            console.log('this is component');
            console.log(this.$route.params.catid);
            this.getData();
        },
    }
</script>