<template>
<InputForm v-bind:event="event" v-bind:errors="errors" @form-submit="onSubmit" />
</template>

<script>
import {
    ElButton,
    ElMessage
} from 'element-plus';
import InputForm from "../components/InputForm.vue";
export default {

    data: function () {
        return {
            event: {
                title: '',
                details: '',
                category: '',
                organizer: '',
                onlineEvent: '',
                url: '',
                startingDate: '',
                startingTime: '',
                endingDate: '',
                endingTime: '',
                location: '',
                limit: '',
                deadline: '',
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
                    data: that.event
                })
                .then(response => {
                    ElMessage({
                        showClose: true,
                        message: response.data.message,
                        type: 'success',
                    })

                    that.$router.push({
                        name: "AllEvents"
                    });
                })
                .fail(error => {})
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
