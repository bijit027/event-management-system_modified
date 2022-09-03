<template>
<el-main>
    <el-row justify="space-evenly">
        <el-col :span="8">
            <div class="wrap">
                <el-card class="box-card">
                    <h3>Add Organizer</h3>
                    <hr>
                    <OrganizerInputForm v-bind:eventOrganizer="eventOrganizer" v-bind:button="button" v-bind:errors="errors" @form-submit="onSubmit" />
                </el-card>
            </div>
        </el-col>

    </el-row>
</el-main>
</template>

<script>
import OrganizerInputForm from "../components/OrganizerInputForm.vue";
import {
    ElButton,
    ElMessage
} from 'element-plus'
export default {
    components: {
        ElButton
    },
    components: {
        OrganizerInputForm
    },

    data() {
        return {
            loading: false,
            events: [],
            organizers: [],
            organizerValue: [],
            eventOrganizer: {
                name: '',
                details: '',
            },
            button: 'Create',
            errorMessage: null,
            showSuccess: '',
            showError: '',
            errors: []
        }
    },
    methods: {

        onSubmit() {

            const that = this
            EMS.adminPost({
                    route: 'add_event_organizer',
                    ems_nonce: ajax_url.ems_nonce,
                    data: that.eventOrganizer,
                })
                .then(response => {
                    ElMessage({
                        showClose: true,
                        message: response.data.message,
                        type: 'success',
                    })

                    that.$router.push({
                        name: "EventOrganizer"
                    });
                })
                .fail(error => {
                    that.errors = error.responseJSON.data;

                    if (error.responseJSON.data.error) {
                        ElMessage.error(error.responseJSON.data.error)
                    }
                })

            // const that = this;

            // jQuery.ajax({
            //     type: "POST",
            //     url: ajax_url.ajaxurl,
            //     dataType: 'json',
            //     data: {
            //         action: "ems_insert_event_organizer_data",
            //         name: that.eventOrganizer.name,
            //         details: that.eventOrganizer.details,
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
            //          if(error.responseJSON.data.error){
            //             ElMessage.error(error.responseJSON.data.error)
            //         }

            //     }
            // });

        },
    }

}
</script>

<style scoped>
.wrap {
    width: 100%;

}
</style>
