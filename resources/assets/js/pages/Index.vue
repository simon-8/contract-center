<template>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <articles-component></articles-component>
            </div>
            <div class="col-md-3 hidden-xs col-md-offset-1">
                <tags-component></tags-component>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
<script>
    import ArticlesComponent from '../components/ArticlesComponent';
    import RecommendsComponent from '../components/RecommendsComponent';
    import TagsComponent from '../components/TagsComponent';

    export default {
        components: {
            'articles-component': ArticlesComponent,
            'recommends-component': RecommendsComponent,
            'tags-component': TagsComponent
        },
        data() {
            return {

            }
        },
        methods: {

        },
        watch: {
        },
        mounted() {
            console.log('Index Page');
        }
    }
</script>
