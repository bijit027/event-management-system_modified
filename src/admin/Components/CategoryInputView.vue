<template>
<div class="form_input">
    <div class="close_button">
        <router-link to="/eventCategory" tag="button">
            <el-button type="info">Back</el-button>
        </router-link>
    </div>
    <el-form label-width="50px" class="form">
        <div class="form-item">
            <el-form-item label="Title" size="small" class="required">
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

    props: ['eventCategory', 'errors', 'button'],
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
