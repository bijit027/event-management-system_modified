<template>
<div>
    <el-form-item>
       <el-button type="primary" @click="allEvents()">Back</el-button>
    </el-form-item>
</div>
</template>

<script>

export default {

    props: ['routerLink'],
    emits: ["form-submit"],
    methods: {
                allEvents() {
            this.$router.push({
                path: routerLink
            })
        },

        // onSubmit() {
        //     this.$emit("form-submit", this.eventCategory);
        // }
    }
}
</script>

<style scoped>
.danger {
    color: red;
}
</style>
