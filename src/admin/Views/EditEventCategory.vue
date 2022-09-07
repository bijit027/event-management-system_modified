<template>
<div class="wrap">
<h2>Edit Category</h2>
    <el-card class="box-card">
        <CategoryInputView v-bind:eventCategory="value" v-bind:button="button" v-bind:errors="errors" @form-submit="onSubmit" />
    </el-card>
</div>
</template>

<script>
import {
    ElButton,
    ElMessage
} from 'element-plus';
import CategoryInputView from "../Components/CategoryInputView.vue";
export default {
    data() {
        return {
            eventCategoryID: this.$route.params.categoryID,
            eventCategory: {},
            value: {
                title: '',
                
            },
            button: 'Update',
            errors: []
        }
    },
    components: {
        CategoryInputView
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            const that = this;
            EMS.adminGet({
                    route: 'get_single_category_data',
                    id: that.eventCategoryID,
                    ems_nonce: ajax_url.ems_nonce,
                })
                .then(response => {
                    that.eventCategory = response.data.single_category_data;
                    that.value.title = that.eventCategory.name;

                })
                .fail(error => {
                    ElMessage.error(error.responseJSON.data.error)
                })
        },
        onSubmit() {
                        const that = this
            EMS.adminPost({
                    route: 'add_event_category',
                    ems_nonce: ajax_url.ems_nonce,
                    id: that.eventCategoryID,
                    data: that.value,
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
            //         id: that.eventCategoryID,
            //         title: that.value.title,
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
