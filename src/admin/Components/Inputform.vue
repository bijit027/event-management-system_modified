<template>
<el-card class="box-card">
    <div class="container">
        <div class="wrap">
            <el-form label-width="100px">
                <div class="form-item">
                    <el-form-item label="Event Title" show-message="false">
                        <el-col>
                            <el-input type="text" size="large" v-model="event.title" />
                            <small class="danger" v-if="errors.title">{{ errors.title }}</small>
                        </el-col>
                    </el-form-item>
                </div>
                <el-form-item label="Event Details">
                    <el-col>
                        <el-input type="textarea" v-model="event.details" />
                        <small class="danger" v-if="errors.details">{{ errors.details }}</small>
                    </el-col>
                </el-form-item>

                <el-form-item>
                    <el-button type="primary" @click="onSubmit">{{ event.button }}</el-button>
                </el-form-item>
          

            </el-form>
        </div>

    </div>
</el-card>
</template>

<script>
export default {

    props: ['event', 'errors'],
    emits: ["form-submit"],

    data() {
        return {
            category: {},
            organizer: {},
            name: '',

        }
    },

    mounted() {

        this.fetchCategory();
        this.fetchOrganizer();
    },

    methods: {
        fetchCategory() {
            // const that = this;
            // jQuery.ajax({
            //     type: "GET",
            //     url: ajax_url.ajaxurl,
            //     dataType: 'json',
            //     data: {
            //         action: "ems_get_event_category_data",
            //     },
            //     success: function (data) {
            //         that.category = data.data;
            //     }
            // });
        },
        fetchOrganizer() {
            // const that = this;
            // jQuery.ajax({
            //     type: "GET",
            //     url: ajax_url.ajaxurl,
            //     dataType: 'json',
            //     data: {
            //         action: "ems_get_organizer_data",
            //     },
            //     success: function (data) {
            //         that.organizer = data.data;
            //     }
            // });

        },
        onSubmit() {
            this.$emit("form-submit", this.event);
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

.danger {
    color: red;
}
</style>
