<template>
    <div class="container">
        <el-row>
            <el-col :span="16" v-loading="loading">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ article.title }}</div>

                    <div class="panel-body">
                        {{ article.created_at }}
                        <h4 v-html="article.introduce"></h4>
                        <div class="markdown-body" v-html="article.content"></div>
                    </div>
                </div>
            </el-col>
            <el-col :span="7" :offset="1" v-loading="loading">
                <!--<Tag></Tag>-->
            </el-col>
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
                axios.get('/single/'+this.id).then((res) => {
                    this.article = res.data;
                    this.loading = false;
                }).catch((res) => {
                    console.log(res);
                });
            }
        },
        mounted() {
            console.log('Single Page');
            this.getData();
        }
    }
</script>
