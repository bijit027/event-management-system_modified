<template>
<div class="main_nav">
    <div class="plugin_name">Event Manager</div>
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
.default .el-input>*>input {
    border: none;
    background: none;
    padding: 0;
}

.default .el-input>*>input:focus {
    box-shadow: none;
    outline: none;
}

.default .el-input>*>input:focus-visible {
    outline: none;
}
.main_nav {
  display: block;
  width: 100%;
  height: 60px;
  overflow: hidden;
  border-bottom: 1px solid rgb(221, 221, 221);
  background-color: #5525d9;
  margin: -20px -20px 0;
  padding: 20px 20px 0px;
  }
    .plugin_name {
    font-size: 16px;
    color: white;
    margin-right: 30px;
    margin-top: 20px;
    }
</style>
