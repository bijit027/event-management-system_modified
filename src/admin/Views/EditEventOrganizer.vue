<template>
<div class="wrap">
    <el-card class="box-card">
        <OrganizerInputForm v-bind:eventOrganizer="value" v-bind:button="button" v-bind:errors="errors" @form-submit="onSubmit" />
    </el-card>
</div>
</template>

<script>
import {
    ElButton,
    ElMessage
} from "element-plus";
import OrganizerInputForm from "../components/OrganizerInputForm.vue";
export default {
    data() {
        return {
            eventOrganizerID: this.$route.params.organizerID,

            eventOrganizer: {},
            value: {
                name: "",
                details: "",
            },
            button: "Update",
            previousValue: "",
            errors: []

        };
    },
    components: {
        OrganizerInputForm,
    },

    mounted() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            const that = this;
            EMS.adminGet({
                    route: 'get_single_organizer_data',
                    id: that.eventOrganizerID,
                    ems_nonce: ajax_url.ems_nonce,
                })
                .then(response => {
                    that.eventOrganizer = response.data.single_organizer_data;
                    that.value.name = that.eventOrganizer.name;
                    that.value.details = that.eventOrganizer.description;

                })
                .fail(error => {
                    ElMessage.error(error.responseJSON.data.error)
                })
            // const that = this;
            // jQuery.ajax({
            //     type: "GET",
            //     url: ajax_url.ajaxurl,
            //     dataType: "json",
            //     data: {
            //         action: "ems_get_single_organizer_data",
            //         id: that.eventCategoryID,
            //     },
            //     success: function (data) {
            //         that.eventOrganizer = data.data;
            //         that.value.name = that.eventOrganizer.name;
            //         that.value.details = that.eventOrganizer.description,
            //             that.value.button = "Update";
            //     },
            // });
        },
        onSubmit() {

            const that = this
            EMS.adminPost({
                    route: 'add_event_organizer',
                    ems_nonce: ajax_url.ems_nonce,
                    id: that.eventOrganizerID,
                    data: that.value,
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
        },
    },
};
</script>

<style scoped>
.wrap {
    width: 60%;
    margin: auto;
    margin-top: 50px;
}
</style>
