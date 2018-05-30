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
                    { name: "PHP", href: "/category/2", target: false },
                    { name: "MySQL", href: "/category/3", target: false },
                    { name: "Linux", href: "/category/4", target: false },
                    //{ name: "关于", href: "/刘文静", target: false }
                ],
            }
        },
        methods: {
            handleSelect(key, keyPath) {

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
        }
    }
</script>

<style scoped>
    .el-menu--horizontal {
        border: none;
    }
</style>