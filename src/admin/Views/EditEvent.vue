<template>
<InputForm v-bind:event="value" v-bind:errors="errors" @form-submit="onSubmit" />
</template>

<script>
import {
    ElButton,
    ElMessage
} from 'element-plus';
import InputForm from "../components/InputForm.vue";
export default {

    data() {
        return {
            eventID: this.$route.params.eventID,
            events: {},
            value: {
                button: '',
            },
            organizer: {},
            ID: '',
            errors: [],
        }
    },
    components: {
        InputForm
    },

    mounted() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            const that = this;
            EMS.adminGet({
                    route: 'get_single_eventData',
                    id: that.eventID
                })
                .then(response => {
                    that.event = response.data.single_event_data;
                    that.value = JSON.parse(that.event.eventData);
                    that.value.button = 'Update';

                })
                .fail(error => {

                })
            // const that = this;
            // jQuery.ajax({
            //     type: "GET",
            //     url: ajax_url.ajaxurl,
            //     dataType: 'json',
            //     data: {
            //         action: "ems_get_single_event_data",
            //         id: that.eventID
            //     },
            //     success: function (data) {
            //         that.events = data.data;
            //         that.val = JSON.parse(that.events.eventData);
            //         that.val.button = 'Update';
            //     }
            // })

        },

        onSubmit() {

            const that = this
            EMS.adminPost({
                    route: 'create_event',
                    id: that.eventID,
                    data: that.value
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
            // const that = this;
            // jQuery.ajax({
            //     type: "POST",
            //     url: ajax_url.ajaxurl,
            //     dataType: 'json',
            //     data: {
            //         action: "ems_edit_event_data",
            //         id: that.eventID,
            //         title: that.val.title,
            //         details: that.val.details,
            //         category: that.val.category,
            //         organizer: that.val.organizer,
            //         onlineEvent: that.val.onlineEvent,
            //         url: that.val.url,
            //         startingDate: that.val.startingDate,
            //         startingTime: that.val.startingTime,
            //         endingDate: that.val.endingDate,
            //         endingTime: that.val.endingTime,
            //         location: that.val.location,
            //         limit: that.val.limit,
            //         deadline: that.val.deadline,
            //         ems_nonce: ajax_url.ems_nonce,
            //     },
            //     success: function (data) {
            //         ElMessage({
            //             showClose: true,
            //             message: data.data.message,
            //             type: 'success',
            //         })

            //     },
            //     error: function (error) {
            //         that.errors = error.responseJSON.data;
            //         if (error.responseJSON.data.error) {
            //             ElMessage.error(error.responseJSON.data.error)
            //         }

            //     }
            // });

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
