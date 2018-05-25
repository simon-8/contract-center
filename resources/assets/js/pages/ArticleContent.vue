<template>
    <div class="container">
        <el-row>
            <el-col :span="24" v-loading="loading">

                <div class="panel panel-default">

                    <div class="panel-heading">
                        <el-breadcrumb separator="/">
                            <el-breadcrumb-item>
                                <router-link to="/">首页</router-link>
                            </el-breadcrumb-item>
                            <el-breadcrumb-item>
                                文章详情
                            </el-breadcrumb-item>
                            <el-breadcrumb-item>
                                <router-link :to="makeUrl(article.id)">{{ article.title }}</router-link>
                            </el-breadcrumb-item>
                        </el-breadcrumb>
                    </div>

                    <div class="panel-body">
                        {{ article.created_at }}
                        <h4 v-html="article.introduce"></h4>
                        <div class="markdown-body" v-html="article.content"></div>
                    </div>
                </div>
                <div>
                    <div class="pull-left">
                        上一篇:
                        <router-link :to="makeUrl(article.prev.id)" v-if="article.prev">{{ article.prev.title }}</router-link>
                        <a v-else>没有了</a>
                    </div>
                    <div class="pull-right">
                        下一篇:
                        <router-link :to="makeUrl(article.next.id)" v-if="article.next">{{ article.next.title }}</router-link>
                        <a v-else>没有了</a>
                    </div>
                </div>
            </el-col>
            <!--<el-col :span="6" v-loading="loading">-->
                <!--<Tag></Tag>-->
            <!--</el-col>-->
        </el-row>
    </div>
</template>

<style>
    @import 'https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/2.10.0/github-markdown.min.css';
</style>

<script>
    export default {
        data() {
            return {
                id: 0,
                article: {},
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
            makeUrl(id) {
                return '/article/'+id+'.html';
            },
            getData () {
                this.loading = true;
                axios.get('/article/'+this.id).then((res) => {
                    this.article = res.data;
                    this.loading = false;
                }).catch((res) => {
                    this.loading = false;
                    console.log(res);
                });
            }
        },
        watch: {
            '$route' (to, from) {
                if (to.params.id && to.params.id !== from.params.id) {
                    this.id = this.$route.params.id;
                    this.getData();
                }
                console.log(to, from);
            },
            articles (newValue, oldValue) {
                if (newValue.length) {
                    //this.setCache('indexArticle', newValue);
                }
            }
        },
        mounted() {
            console.log('Content Page');
            this.id = this.$route.params.id;
            this.getData();
        }
    }
</script>
