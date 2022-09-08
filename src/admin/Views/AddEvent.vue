<template>
<EventInputView v-bind:event="event" v-bind:button="button" v-bind:errors="errors" @form-submit="onSubmit" />
</template>

<script>
import {
    ElButton,
    ElMessage
} from 'element-plus';
import EventInputView from "../Components/EventInputView.vue";
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

            },
            button: 'Create',

            showSuccess: '',
            showError: '',
            errors: [],
        }
    },
    components: {
        EventInputView
    },

    methods: {
        onSubmit() {
            const that = this
            EMS.adminPost({
                    route: 'create_event',
                    ems_nonce: ajax_url.ems_nonce,
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
                .fail(error => {
                    that.errors = error.responseJSON.data;
                    
                    if (error.responseJSON.data.error) {
                        ElMessage.error(error.responseJSON.data.error)
                    }
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
