<template>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <tag-article-component></tag-article-component>
            </div>
            <div class="col-md-3 hidden-xs col-md-offset-1">
                <tag-component></tag-component>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
<script>
    import TagArticleComponent from '../components/TagArticleComponent';
    import RecommendsComponent from '../components/RecommendsComponent';
    import TagsComponent from '../components/TagsComponent';

    export default {
        components: {
            'tag-article-component': TagArticleComponent,
            'recommends-component': RecommendsComponent,
            'tag-component': TagsComponent
        },
        data() {
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

        },
        watch: {

        },
        mounted() {
            console.log('Tag Page');
        }
    }
</script>
