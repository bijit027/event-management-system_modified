<template>
<div>
    <!-- <el-card class="box-card"> -->
    <el-form label-width="100px">
        <div class="close_button">
            <router-link to="/eventOrganizer" tag="button">
                <el-button type="info">Back</el-button>
            </router-link>
        </div>
        <div class="form-item">
            <el-form-item label="Name" class="required">
                <el-col>
                    <el-input type="text" size="large" v-model="eventOrganizer.name" />
                    <small class="danger" v-if="errors.name">{{ errors.name }}</small>
                </el-col>
            </el-form-item>
            <el-form-item label="Details" class="required">
                <el-col>
                    <el-input type="textarea" v-model="eventOrganizer.details" />
                    <small class="danger" v-if="errors.details">{{ errors.details }}</small>
                </el-col>
            </el-form-item>
        </div>
        <div>
            <el-form-item>
                <el-button type="primary" @click="onSubmit">{{ button }}</el-button>
            </el-form-item>
        </div>
    </el-form>
    <!-- </el-card> -->

</div>
</template>

<script>
export default {

    props: ['eventOrganizer', 'errors', 'button'],
    emits: ["form-submit"],
    methods: {

        onSubmit() {
            this.$emit("form-submit", this.eventOrganizer);
        }
    }
}
</script>

<style scoped>
.danger {
    color: red;
}
</style>
