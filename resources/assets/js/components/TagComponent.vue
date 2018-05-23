<template>
    <div>
        <h3>标签云</h3>
        <p class="col-sm-3" v-for="i in 12">
            <el-tag type="success">标签{{ i }}</el-tag>
        </p>
    </div>
</template>

<style scoped>
    .el-tag {
        background-color: rgba(89,170,251,.1);
        padding: 0 10px;
        height: 32px;
        line-height: 30px;
        font-size: 12px;
        color: #59AAFB;
        border-radius: 4px;
        box-sizing: border-box;
        border: 1px solid rgba(89,170,251,.2);
        white-space: nowrap;
    }
    .el-tag+.el-tag {
        margin-left: 10px;
    }
</style>

<script>
    export default {

    }
</script>