<template>
    <div class="container">
        <el-row>
            <el-col :span="16">
                <articles-component></articles-component>
            </el-col>
            <el-col :span="7" :offset="1">
                <recommends-component></recommends-component>
            </el-col>
        </el-row>
    </div>
</template>

<style scoped>

</style>
<script>
    import ArticlesComponent from '../components/ArticlesComponent';
    import RecommendsComponent from '../components/RecommendsComponent';
    export default {
        components: {
            'articles-component': ArticlesComponent,
            'recommends-component': RecommendsComponent,
        },
        data() {
            return {

            }
        },
        methods: {
            getCache (name) {
                return this.$store.state[name];
            },
            setCache (name, data) {
                this.$store.state[name] = data;
            }
        },
        watch: {

        },
        mounted() {
            console.log('Index Page');
        }
    }
</script>
