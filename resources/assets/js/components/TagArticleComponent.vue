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
                tag: {},
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
            getTag () {
                let name = this.$route.params.name;
                let tagsCache = this.getCache('tags') || [];
                if (tagsCache && tagsCache.length) {
                    tagsCache.forEach((val, index) => {
                        if (val.name === name) {
                            this.tag = val;
                        }
                    });
                    return this.tag;
                }
                return [];

            },
            getData () {
                this.loading = true;
                axios.get(this.getAPI('tagArticle') + this.tag.id).then((res) => {
                    let data = res.data;
                    this.articles = data.data;
                    this.total = data.total;
                    this.loading = false;
                }).catch((res) => {
                    this.$message.error(res);
                });
            }
        },
        watch: {
            '$route' (to, from) {
                console.log('this is tag component');
                console.log(this.$route.params.name);
                if (to.params.name !== this.tag.name) {
                    this.getTag();
                    //this.getData();
                }
            },
            tag (newValue, oldValue) {
                this.getData();
            },
            $store (newValue) {
                console.log('store');
                console.log(newValue)
            }
        },
        mounted () {
            console.log('this is component');
            this.getTag();
            //this.getData();
        },
    }
</script>