<template>
    <div>
        <h3>标签云</h3>
        <div class="tags-container">
            <router-link :to="tagUrl(tag.name)" v-for="tag of tags" :key="tag.id">
                <el-tag :type="randomType()">{{ tag.name }}</el-tag>
            </router-link>
        </div>
    </div>
</template>

<style scoped>
    .tags-container a {
        display: inline-block;
        margin: .7rem .7rem 0 0;
    }
</style>

<script>
    export default {
        data () {
            return {
                tags: []
            }
        },
        methods: {
            getCache (name) {
                return this.$store.state[name];
            },
            setCache (name, data) {
                this.$store.state[name] = data;
                return true;
            },
            tagUrl (name) {
                return '/tag/'+name;
            },
            randomType () {
                let arr = [
                    'success',
                    'info',
                    'warning',
                    'danger'
                ];
                let key = Math.round(Math.random() * 4);
                return arr[key];
            },
            getData () {
                let cache = this.getCache('tags') || [];
                if (cache.length) {
                    this.tags = cache;
                    return;
                }
                axios.get(this.getAPI('tag')).then((res) => {
                    this.tags = res.data;
                    this.setCache('tags', this.tags);
                }).catch((res) => {
                    this.$message.error('获取标签出错');
                    console.log(res);
                })
            }
        },
        mounted () {
            this.getData();
        }
    }
</script>