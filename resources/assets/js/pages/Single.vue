<template>
    <div class="container">
        <div class="row">
            <div class="col-md-9" v-loading="loading">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ article.title }}</div>

                    <div class="panel-body">
                        {{ article.created_at }}
                        <h4 v-html="article.introduce"></h4>
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
</style>

<script>
    export default {
        data() {
            return {
                id: 0,
                article: {},
                loading: true,
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
                this.$http.get('/single/'+this.id).then((res) => {
                    this.article = res.data;
                    this.loading = false;
                }).catch((res) => {
                    console.log(res);
                });
            }
        },
        mounted() {
            this.getData();
        }
    }
</script>
