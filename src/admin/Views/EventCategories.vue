<template>
<el-main>
    <div>
        <h2>ALL Categories</h2>
    </div>
    <el-button type="primary" @click="addCategory()">Add Category</el-button>

    <el-table :data="displayData" style="width: 100%">
        <el-table-column label="Term ID" prop="term_id" />
        <el-table-column label="Category" prop="name" />
        <el-table-column align="right">
            <template #default="scope">
                <el-button size="small" @click="editCategroy(scope.$index, scope.row)">Edit</el-button>
                <el-button size="small" type="danger" @click="confirmDeleteMessage(scope.row)">Delete</el-button>
            </template>
        </el-table-column>
    </el-table>

    <el-row>
        <div class="pagination-block">
            <el-pagination background layout="sizes,total,prev, pager, next,jumper" @current-change="handleCurrentChange" @size-change="handleSizeChange" :page-size="pageSize" :page-sizes="[5,10,15,20]" :total="category.length" />
        </div>
    </el-row>

    <!--Delete event Confimation Modal-->
    <el-dialog title="Are You Sure, You want to delete this category?" v-model="deleteDialogVisible" :show-close="false" width="40%">
        <div class="modal_body">
            <p>Category ID: {{ deleteingCategory.term_id }}? </p>
        </div>
        <span slot="footer" class="dialog-footer">
            <el-button type="danger" @click="deleteDialogVisible = false">Cancel</el-button>
            <el-button type="primary" @click="deletCategory(deleteingCategory.term_id)">Confirm</el-button>
        </span>
    </el-dialog>
</el-main>
</template>

<script>
import {
    ElButton,
    ElMessage
} from 'element-plus'
export default {
    components: {
        ElButton
    },
    components: {

    },

    data() {
        return {
            loading: false,
            events: [],
            category: [],
            eventCategory: {
                title: '',
                button: 'Create'
            },
            errorMessage: null,
            showSuccess: '',
            showError: '',
            page: 1,
            pageSize: 5,
            deleteingCategory: {},
            deleteDialogVisible: false,
        }
    },

    mounted() {
        this.fetchData();
    },
    computed: {
        displayData() {
            if (!this.category || this.category.length === 0) return [];
            return this.category.slice(this.pageSize * this.page - this.pageSize, this.pageSize * this.page)
        }
    },
    methods: {
        addCategory() {
            this.$router.push({
                path: `/addEventCategory`
            })
        },
        handleCurrentChange(val) {
            this.page = val;
        },
        handleSizeChange(val) {
            this.pageSize = val;
        },
        confirmDeleteMessage(category) {
            this.deleteingCategory = category;
            this.deleteDialogVisible = true;
        },

        editCategroy(index, row) {
            this.$router.push({
                path: `/eventCategory/${row.term_id}`
            })
        },

        deletCategory(id) {
            const that = this;
            EMS.adminPost({
                    route: 'delete_category',
                    id: id,
                    ems_nonce: ajax_url.ems_nonce,
                })
                .then(response => {
                    this.fetchData();
                    ElMessage({
                        showClose: true,
                        message: response.data.message,
                        type: 'success',
                    })
                    this.deleteDialogVisible = false;
                })
                .fail(error => {
                    ElMessage.error(error.responseJSON.data.error);
                    this.deleteDialogVisible = false;
                })
            // const that = this;
            // jQuery.ajax({
            //     type: "POST",
            //     url: ajax_url.ajaxurl,
            //     dataType: 'json',
            //     data: {
            //         action: "ems_delete_category",
            //         id: row.term_id,
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
            //         ElMessage.error(error.responseJSON.data.error)

            //     },
            // });
        },
        fetchData() {
            const that = this;
            EMS.adminGet({
                    route: 'get_category_Data',
                    ems_nonce: ajax_url.ems_nonce,
                })
                .then(response => {
                    that.category = response.data.category_data;

                })
                .fail(error => {

                })
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
    }

}
</script>

<style>

</style>
