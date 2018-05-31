<template>
    <div class="container">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/2.10.0/github-markdown.min.css" v-if="article.is_md">
        <div class="row">
            <div class="col-xs-12 col-md-8" v-loading="loading">
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
                                <router-link :to="articleUrl(article.id)">{{ article.title }}</router-link>
                            </el-breadcrumb-item>
                        </el-breadcrumb>
                    </div>

                    <div class="panel-body">
                        <h3 class="text-center">{{ article.title }}</h3>
                        <!--<p class="text-center">{{ article.created_at }}</p>-->
                        <div class="clear">&nbsp;</div>
                        <!--<h4 v-html="article.introduce"></h4>-->
                        <div class="markdown-body" v-html="article.content"></div>
                    </div>
                </div>

            </div>
            <div class="col-md-3 hidden-xs col-md-offset-1">
                <tag-component></tag-component>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .panel {
        border: none;
    }
</style>

<script>
    import TagComponent from '../components/TagComponent';

    export default {
        components: {
            'tag-component': TagComponent
        },
        data() {
            return {
                id: 0,
                article: {},
                loading: false,
                IDMap: {
                    '刘文静': 1
                }
            }
        },
        methods: {
            getParam () {
                if (this.$route.params.id) {
                    this.id = this.$route.params.id;
                    return ;
                }
                if (isNaN(this.$route.params.name) && this.IDMap[this.$route.params.name]) {
                    this.id = this.IDMap[this.$route.params.name];
                    return ;
                }
            },
            getCache (name) {
                return this.$store.state[name];
            },
            setCache (name, data) {
                this.$store.state[name] = data;
            },
            getData () {
                this.getParam();
                this.loading = true;
                axios.get(this.getAPI('single') + '/'+this.id).then((res) => {
                    this.article = res.data;
                    this.loading = false;
                    this.seoInfo(this.article.title, this.article.introduce);
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
            },
            articles (newValue, oldValue) {
                if (newValue.length) {
                    //this.setCache('indexArticle', newValue);
                }
            }
        },
        mounted() {
            console.log('Single Page');
            this.id = this.$route.params.id;
            this.getData();
        }
    }
</script>
