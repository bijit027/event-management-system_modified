<template>
<el-main>
    <div class="wrap">
        <h2>Add Category</h2>
        <el-card class="box-card">
            <CategoryInpuView v-bind:eventCategory="eventCategory" v-bind:button="button" v-bind:errors="errors" @form-submit="onSubmit" />
        </el-card>
    </div>
</el-main>
</template>

<script>
import CategoryInpuView from "../Components/CategoryInpuView.vue";
import {
    ElButton,
    ElMessage
} from 'element-plus'

export default {
    components: {
        ElButton,
        ElMessage

    },
    components: {
        CategoryInpuView
    },

    data() {
        return {
            loading: false,
            events: [],
            category: [],
            eventCategory: {
                title: '',
                
            },
            button: 'Create',
            errorMessage: null,
            showSuccess: '',
            showError: '',
            errors:[]
        }
    },

    methods: {
        onSubmit() {


            const that = this
            EMS.adminPost({
                    route: 'add_event_category',
                    ems_nonce: ajax_url.ems_nonce,
                    data: that.eventCategory,
                })
                .then(response => {
                    ElMessage({
                        showClose: true,
                        message: response.data.message,
                        type: 'success',
                    })

                    that.$router.push({
                        name: "EventCategories"
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
            //         action: "ems_insert_event_category_data",
            //         title: that.eventCategory.title,
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
            //         // ElMessage.error(error.responseJSON.data.error)
            //         that.errors = error.responseJSON.data;
            //         if(error.responseJSON.data.error){
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
    width: 60%;
    margin: auto;
    margin-top: 50px;
}

</style>
