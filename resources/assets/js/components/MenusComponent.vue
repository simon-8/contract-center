<template>
    <el-menu mode="horizontal"
             class="pull-right"
             text-color="rgba(255, 255, 255, .5)"
             background-color="#4183c4"
             active-text-color="#FFFFFF" :default-active="$route.path"
             @select="handleSelect" router>
        <template v-for="item in menus">
            <el-menu-item :index="item.href">{{ item.name }}</el-menu-item>
        </template>
    </el-menu>
</template>

<script>
    export default {
        name: "MenusComponent",
        data () {
            return {
                menus: [
                    { name: "首页", href: "/", target: false },
                ],
            }
        },
        methods: {
            handleSelect(key, keyPath) {

            },
            makeCatUrl (catid) {
                return "/category/" + catid;
            },
            makeSingleUrl (id) {
                return '/single/' + id;
            },
            getData () {
                axios.get(this.getAPI('menus')).then((res) => {
                    let data = res.data;
                    if (data.categorys) {
                        data.categorys.forEach((v, k) => {
                            if (k > 2) return false;
                            this.menus.push({
                                href: this.makeCatUrl(v.id),
                                name: v.name,
                                target: false
                            });
                        })
                    }
                    //if (data.singles) {
                    //    data.singles.forEach((v, k) => {
                    //        console.log(v);
                    //        this.menus.push({
                    //            href: this.makeSingleUrl(v.id),
                    //            name: v.name,
                    //            target: false
                    //        });
                    //    })
                    //}
                    //console.log(this.menus);
                }).catch((res) => {
                    this.$message.error(res);
                    console.error(res);
                });
            }
        },
        watch: {
            '$route' (to, from) {
                this.menus.forEach((item, index) => {
                    if (item.href === to.path) {
                        this.seoInfo(item.name);
                    }
                });
            },
        },
        mounted () {
            this.getData();
        }
    }
</script>

<style scoped>
    .el-menu--horizontal {
        border: none;
    }
</style>