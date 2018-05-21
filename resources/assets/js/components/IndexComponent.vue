<template>
    <div class="container">
        <div class="row">

            <i class="el-icon-edit"></i>
            <i class="el-icon-share"></i>
            <i class="el-icon-delete"></i>
            <el-button type="primary" icon="el-icon-search">搜索</el-button>

            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Article Component</div>

                    <div class="panel-body">
                        I'm an example component!
                        <ul>
                            <li v-for="item of articles">
                                <a :href="getLink(item.id)">{{ item.title }}</a>
                                <span>{{ item.created_at }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .panel-body ul {
        width: 100%;
    }
    .panel-body ul li span {
        float: right;
    }
</style>
<script>
    export default {
        data() {
            return {
                articles: []
            }
        },
        methods: {
            getData () {
                this.$http.get('article').then((res) => {
                    let data = res.data;
                    this.articles = data.data;
                }).catch((res) => {
                    console.log(res);
                });
            },
            getLink(id) {
                return '/content/'+id;
            }
        },

        mounted() {
            console.log('Component mounted.');
            this.getData();
        }
    }
</script>
