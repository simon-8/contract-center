<template>
    <div class="container">
        <el-row>
            <el-col :span="16">
                <div class="articles" v-loading="loading">
                    <el-row v-for="item of articles" tag="article" :gutter="10" :key="item.id">
                        <el-col :span="6" class="article-thumb">
                            <img :src="item.thumb" alt="" width="100%">
                        </el-col>

                        <el-col :span="18" class="article-info">
                            <h4>
                                <router-link :to="makeUrl(item.id)">{{ item.title }}</router-link>
                            </h4>

                            <p class="introduce" v-html="item.introduce"></p>
                            <p class="meta">
                                <span class="meta-info">
                                    <i class="glyphicon glyphicon-time"></i>
                                    {{ item.created_at }}
                                </span>
                                <span class="meta-info">
                                    <i class="glyphicon glyphicon-tags"></i>
                                     PHP
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
                        </el-col>
                    </el-row>
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
            </el-col>
            <el-col :span="7" :offset="1">
                <!--<Project></Project>-->
            </el-col>
        </el-row>
    </div>
</template>

<style scoped>
    li {
        list-style: none;
    }

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

</style>
<script>

    export default {
        data() {
            return {
                articles: [],
                currentPage: 1,
                pageSize: 10,
                total: 0,
                loading: false
            }
        },
        methods: {
            getCache (name) {
                return this.$store.state[name];
            },
            setCache (name, data) {
                this.$store.state[name] = data;
            },
            getData (page = 1) {
                //if (page > 1) {
                    let cacheData = this.getCache('indexCache');
                    console.log(cacheData, page);
                    if (cacheData && cacheData.data.length && cacheData.current_page === page) {
                        this.articles = cacheData.data;
                        this.total = cacheData.total;
                        this.currentPage = cacheData.current_page;
                        return;
                    }
                //}
                this.currentPage = page;
                this.loading = true;
                this.articles = [];
                axios.get('article?page='+ page+'&pagesize='+this.pageSize).then((res) => {
                    this.setCache('indexCache', res.data);
                    let data = res.data;
                    this.articles = data.data;
                    this.total = data.total;
                    this.loading = false;
                }).catch((res) => {
                    console.log(res);
                });
            },
            makeUrl(id) {
                return '/article/'+id+'.html';
            }
        },
        watch: {
            articles (newValue, oldValue) {
                if (newValue.length) {
                    //this.setCache('indexArticle', newValue);
                }
            }
        },
        mounted() {
            console.log('Index Page');
            //console.log(this.$route.params);
            this.getData();
        }
    }
</script>
