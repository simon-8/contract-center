<template>
    <el-row>
        <h3>推荐文章</h3>
        <el-col :span="24" class="project" v-for="i of 5" :key="i">
        <!--<div class="col-sm-10 project">-->
            <el-card :body-style="{ padding: '0px' }">
                <img src="https://simon8.com/upload/thumb/201705/20170522155350_93623.gif" class="image">
                <div style="padding: 14px;">
                    <span>好吃的汉堡汉堡汉堡</span>
                    <div class="bottom clearfix">
                        <time class="time">2018年5月25日 11:27:10</time>
                        <el-button type="text" class="button">操作按钮</el-button>
                    </div>
                </div>
            </el-card>
        <!--</div>-->
        </el-col>
    </el-row>
</template>

<style scoped>
    .project {
        padding: 0;
        margin: 0 0 10px 0;
    }
    .time {
        font-size: 13px;
        color: #999;
    }
    .button {
        padding: 0;
        float: right;
    }
    .image {
        width: 100%;
        display: block;
    }

    .clearfix:before,
    .clearfix:after {
        display: table;
        content: "";
    }

    .clearfix:after {
        clear: both
    }
</style>

<script>
    export default {
        data () {
            return {

            }
        },
        methods: {

        },
        watch: {

        },
        mounted () {

        }
    }
</script>