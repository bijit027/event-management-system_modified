<template>
<!-- <div class="main_nav">
    <div class="plugin_name">Event Manager</div>

</div> -->

<el-header>

    <el-menu :default-active="activeIndex" class="el-menu-demo" mode="horizontal" background-color="#5525d9" text-color="#fff" active-text-color="#ffd04b" @select="handleSelect">
        <el-menu-item index="/">Event Manager</el-menu-item>

        <!-- <el-menu-item index="4">
            <router-link to="/eventCategory">Categories</router-link>
        </el-menu-item>

        <el-menu-item index="4">
            <router-link to="/eventOrganizer">Organizer</router-link>
        </el-menu-item> -->
        <el-menu-item index="/eventCategory">Categories</el-menu-item>
        <el-menu-item index="/eventOrganizer">Organizer</el-menu-item>

    </el-menu>
</el-header>
<div>
    <router-view class="default"></router-view>
</div>
</template>

<script>
export default {
    data() {
        return {
            // activeIndex: '1',
            activeIndex: '1'
        }
    },
    methods: {
        handleSelect(key, keyPath) {
           
            this.$router.push({
                path: key
            })
        }
    }
}
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

.required .el-form-item__label::before {
    content: '*';
    color: red;
    margin-right: 5px;
}

.el-descriptions__cell .el-descriptions__label {
    color: black;
    font-weight: bold;

}
.close_button {
    text-align: start;
    margin-bottom:20px;
}
</style>
