<template>
    <el-container>
        <el-header>
            <el-menu mode="horizontal" background-color="rgb(64, 158, 255)"
                     text-color="#fff"
                     active-text-color="rgb(28, 129, 232)" @select="handleSelect" router>
                <el-menu-item index="/">首页</el-menu-item>
                <el-menu-item index="/article">文章管理</el-menu-item>
                <!--<el-submenu index="2">-->
                    <!--<template slot="title">我的工作台</template>-->
                    <!--<el-menu-item index="2-1">选项1</el-menu-item>-->
                    <!--<el-menu-item index="2-2">选项2</el-menu-item>-->
                    <!--<el-menu-item index="2-3">选项3</el-menu-item>-->
                    <!--<el-submenu index="2-4">-->
                        <!--<template slot="title">选项4</template>-->
                        <!--<el-menu-item index="2-4-1">选项1</el-menu-item>-->
                        <!--<el-menu-item index="2-4-2">选项2</el-menu-item>-->
                        <!--<el-menu-item index="2-4-3">选项3</el-menu-item>-->
                    <!--</el-submenu>-->
                <!--</el-submenu>-->
                <el-menu-item index="/webpage">单页管理</el-menu-item>
                <el-menu-item index="4"><a href="https://www.ele.me" target="_blank">订单管理</a></el-menu-item>
            </el-menu>
        </el-header>

        <el-main>
            <router-view></router-view>
        </el-main>

        <el-footer>

        </el-footer>
    </el-container>
</template>

<script>
    export default {
        name: "App",
        data() {
            return {
                msg: 'Vue'
            }
        },
        methods: {
            handleSelect(key, keyPath) {
                console.log(key, keyPath);
            }
        }
    }
</script>

<style scoped>
    header {
        background-color: rgb(64, 158, 255);
    }
    /*.el-menu {*/
        /*background-color: rgb(64, 158, 255);*/
    /*}*/
    /*.el-menu-item, .el-menu-item a, .el-submenu__title{*/
        /*color: white !important;*/
    /*}*/
</style>