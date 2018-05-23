<template>
    <div class="container">
        <div class="row">
            <div class="col-md-9" v-loading="loading">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ article.title }}</div>

                    <div class="panel-body">
                        {{ article.created_at }}
                        <h4>{{ article.introduce }}</h4>
                        <div class="markdown-body" v-html="article.content"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3" v-loading="loading">
                <Tag></Tag>
            </div>
        </div>
    </div>
</template>

<style>
    @import 'https://cdnjs.cloudflare.com/ajax/libs/github-markdown-css/2.10.0/github-markdown.min.css';
    .el-tag {
        background-color: rgba(89,170,251,.1);
        padding: 0 10px;
        height: 32px;
        line-height: 30px;
        font-size: 12px;
        color: #59AAFB;
        border-radius: 4px;
        box-sizing: border-box;
        border: 1px solid rgba(89,170,251,.2);
        white-space: nowrap;
    }
    .el-tag+.el-tag {
        margin-left: 10px;
    }
</style>

<script>
    export default {
        data() {
            return {
                id: 0,
                article: {},
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
                this.$http.get('/article/'+this.id).then((res) => {
                    this.article = res.data;
                    this.loading = false;
                }).catch((res) => {
                    console.log(res);
                });
            }
        },
        mounted() {
            this.id = this.$route.params.id;
            this.getData();
        }
    }
</script>
