<template>
<EventInputView v-bind:event="value" v-bind:button="button" v-bind:errors="errors" @form-submit="onSubmit" />
</template>

<script>
import {
    ElButton,
    ElMessage
} from 'element-plus';
import EventInputView from "../components/EventInputView.vue";
export default {

    data() {
        return {
            eventID: this.$route.params.eventID,
            events: {},
            value: {
               
            },
            button: 'Update',
            organizer: {},
            ID: '',
            errors: [],
        }
    },
    components: {
        EventInputView
    },

    mounted() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            const that = this;
            EMS.adminGet({
                    route: 'get_single_eventData',
                    id: that.eventID,
                    ems_nonce: ajax_url.ems_nonce,
                })
                .then(response => {
                    that.event = response.data.single_event_data;
                    that.value = JSON.parse(that.event.eventData);

                })
                .fail(error => {
                    ElMessage.error(error.responseJSON.data.error)
                })
        },

        onSubmit() {

            const that = this
            EMS.adminPost({
                    route: 'create_event',
                    id: that.eventID,
                    ems_nonce: ajax_url.ems_nonce,
                    data: that.value,

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
    }

}
</script>

<style scoped>
.box-card {
    width: 60%;
    margin: auto;
    margin-top: 50px;
}
</style>
