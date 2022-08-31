<template>
<InputForm v-bind:event="event" v-bind:errors="errors" @form-submit="onSubmit" />
</template>

<script>
import {
    ElButton,
    ElMessage
} from 'element-plus';
import InputForm from "../components/InputForm.vue";
// import EMS from "../../EMS.js";
export default {

    data: function () {
        return {
            // EMS,
            event: {

                title: '',
                details: '',
                button: 'Create',
            },

            showSuccess: '',
            showError: '',
            errors: [],
        }
    },
    components: {
        InputForm
    },

    methods: {
        onSubmit() {
           const that = this
            EMS.adminPost({
                route: 'create_event',
                title: that.event.title,
                details: that.event.details,
            })
        }
    },
}
</script>

<style scoped>
.container {
    width: 100%;
    padding: 10px;
}

.timePicker {
    margin-left: 20px;
    margin-right: 10px;
}

.box-card {
    width: 60%;
    margin: auto;
    margin-top: 50px;
}
</style>
