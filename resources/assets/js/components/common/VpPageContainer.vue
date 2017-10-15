<template>
    <el-row type="flex">
        <el-col :span="18" :offset="3">
            <slot></slot>
        </el-col>
    </el-row>
</template>

<style lang="scss" scoped>
    .profile {

        .el-card {
            border: 0!important;
            border-radius: 0!important;
        }

    }

    .el-card.box-card.vp-col-1 > div {
        padding: 0!important;
    }
</style>
<style lang="scss">
    .profile {

        .el-card.box-card.vp-col-1 > div {
            padding: 20px 0 0 0!important;
        }
    }
</style>
