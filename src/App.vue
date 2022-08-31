<template>
<div>
    Hello world

</div>
<div>
    <router-view class="default"></router-view>
</div>
</template>

<script>
export default {
    data() {
        return {};
    },
};
</script>

<style>

.default .el-input > * > input {
    border: none;
    background: none;
    padding: 0;
}

.default .el-input > *  > input:focus {
    box-shadow: none;
    outline: none;
}

.default .el-input > * > input:focus-visible {
    outline: none;
}
</style>
