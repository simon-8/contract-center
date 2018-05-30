<template>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <articles-component></articles-component>
            </div>
            <div class="col-md-3 hidden-xs col-md-offset-1">
                <recommends-component></recommends-component>
            </div>
        </div>
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
