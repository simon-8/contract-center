<template>
    <div class="container">
        <div class="row">

            <div class="col-md-9">
                <div class="articles" v-loading="loading">
                    <article v-for="item of articles" class="row">
                        <div class="article-thumb col-sm-3">
                            <!--<p class="thumb">-->
                            <img src="https://simon8.com/upload/thumb/201705/20170522155350_93623.gif" alt="">
                            <!--</p>-->
                        </div>
                        <div class="article-info col-sm-9">
                            <h3>
                                <a :href="makeUrl(item.id)">{{ item.title }}</a>
                            </h3>

                            <p class="introduce">
                                {{ item.introduce }}
                            </p>
                            <p class="meta">
                                <span class="meta-info">
                                    <i class="el-icon-date"></i>
                                    {{ item.created_at }}
                                </span>
                                    <span class="meta-info">
                                    <i class="el-icon-edit"></i>
                                    PHP
                                </span>
                            </p>
                        </div>
                    </article>
                </div>

                <div class="clear">&nbsp;</div>

                <div class="text-center" v-if="articles.length">
                    <el-pagination
                            background
                            layout="prev, pager, next"
                            :total="50"
                            :current-page="currentPage"
                            >
                    </el-pagination>
                </div>
            </div>
            <div class="col-md-3">
                <Tag></Tag>
            </div>
        </div>
    </div>
</template>

<style scoped>
    /** {*/
        /*font-family: "Helvetica Neue",Helvetica,"PingFang SC","Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;*/
    /*}*/
    li {
        list-style: none;
    }

    article {
        border-bottom: 1px solid #eee;
        padding: 10px 0;
        position: relative;
    }
    article h3 {
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
                currentPage: 2,
                loading: true
            }
        },
        methods: {
            getCache (name) {
                return this.$store.state[name];
            },
            setCache (name, data) {
                this.$store.state[name] = data;
            },
            getData () {
                let cacheData = this.getCache('indexArticle');
                if (cacheData.length) {
                    this.articles = cacheData;
                    return;
                }
                this.$http.get('article').then((res) => {
                    let data = res.data;
                    this.articles = data.data;
                }).catch((res) => {
                    console.log(res);
                });
            },
            makeUrl(id) {
                return '/content/'+id;
            }
        },
        watch: {
            articles (newValue, oldValue) {
                if (newValue.length) {
                    this.setCache('indexArticle', newValue);
                }
                this.loading = false;
            }
        },
        mounted() {
            this.getData();
        }
    }
</script>
