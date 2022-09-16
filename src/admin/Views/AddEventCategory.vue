<template>
    <el-main>
        <div class="wrap">
            <h2>Add Category</h2>
            <el-card class="box-card">
                <CategoryInputView
                    v-bind:eventCategory="eventCategory"
                    v-bind:button="button"
                    v-bind:errors="errors"
                    @form-submit="onSubmit"
                />
            </el-card>
        </div>
    </el-main>
</template>

<script>
import CategoryInputView from "../Components/CategoryInputView.vue";
import { ElButton, ElMessage } from "element-plus";

export default {
    components: {
        ElButton,
        ElMessage,
    },
    components: {
        CategoryInputView,
    },

    data() {
        return {
            loading: false,
            events: [],
            category: [],
            eventCategory: {
                title: "",
            },
            button: "Create",
            errorMessage: null,
            showSuccess: "",
            showError: "",
            errors: [],
        };
    },

    methods: {
        onSubmit() {
            const that = this;
            EMS.adminPost({
                route: "add_event_category",
                ems_nonce: ajax_url.ems_nonce,
                data: that.eventCategory,
            })
                .then((response) => {
                    ElMessage({
                        showClose: true,
                        message: response.data.message,
                        type: "success",
                    });

                    that.$router.push({
                        name: "EventCategories",
                    });
                })
                .fail((error) => {
                    that.errors = error.responseJSON.data;

                    if (error.responseJSON.data.error) {
                        ElMessage.error(error.responseJSON.data.error);
                    }
                });
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
