<template>
<div>
    <el-form label-width="100px">
        <div class="form-item">
            <el-form-item label="Title">
                <el-col>
                    <el-input type="text" size="large" v-model="eventCategory.title" />
                    <small class="danger" v-if="errors.title">{{ errors.title }}</small>
                </el-col>
            </el-form-item>
        </div>
        <div>
            <el-form-item>
                <el-button type="primary" @click="onSubmit">{{ button }}</el-button>
            </el-form-item>
        </div>
    </el-form>
</div>
</template>

<script>
export default {

    props: ['eventCategory','errors','button'],
    emits: ["form-submit"],
    methods: {

        onSubmit() {
            this.$emit("form-submit", this.eventCategory);
        }
    }
}
</script>

<style scoped>
.danger {
    color: red;
}
</style>
