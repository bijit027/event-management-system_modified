<template>
<el-main>
    <div>
        <h2>ALL Events</h2>
    </div>
    <el-button type="primary" @click="addEvent()">Add Event</el-button>
    <el-row>
        <el-table :data="displayData" style="width: 100%">
            <el-table-column label="Date" prop="post_date" />
            <el-table-column label="Event" prop="post_title" />
            <el-table-column align="right">
                <template #default="scope">
                    <el-button size="small" type="primary" @click="showSingleData(scope.$index, scope.row)">View</el-button>
                    <el-button size="small" @click="editEventData(scope.$index, scope.row)">Edit</el-button>
                    <el-button size="small" type="danger" @click="confirmDeleteMessage(scope.row)">Delete</el-button>
                </template>
            </el-table-column>
        </el-table>
    </el-row>
    <el-row v-if="events.length>10">
        <div class="pagination-block">
            <el-pagination background layout="total,sizes,prev, pager, next,jumper" @current-change="handleCurrentChange" @size-change="handleSizeChange" :page-size="pageSize" :page-sizes="[10, 20, 30, 40]" :total="events.length" />
        </div>
    </el-row>

    <!--Delete form Confimation Modal-->
    <el-dialog title="Are You Sure, You want to delete this form?" v-model="deleteDialogVisible" :show-close="false" width="40%">
        <div class="modal_body">
            <p>All the data assoscilate with this form will be deleted, including payment information and other
                associate information</p>
            <p>You are deleting Event Title: </p>
        </div>
        <span slot="footer" class="dialog-footer">
            <el-button type="danger" @click="deleteDialogVisible = false">Cancel</el-button>
            <el-button type="primary" @click="deletEvent(deleteingForm.ID)">Confirm</el-button>
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
    data() {
        return {
            loading: false,
            events: [],
            errorMessage: null,
            showSuccess: '',
            showError: '',
            page: 1,
            pageSize: 10,
            deleteingForm: {},
            deleteDialogVisible: false,
        }
    },

    mounted() {

        this.fetchData();
    },
    computed: {
        displayData() {
            if (!this.events || this.events.length === 0) return [];
            return this.events.slice(this.pageSize * this.page - this.pageSize, this.pageSize * this.page)
        }
    },
    methods: {
        handleCurrentChange(val) {
            this.page = val;
        },
        handleSizeChange(val) {
            this.pageSize = val;
        },
        confirmDeleteMessage(form) {
            this.deleteingForm = form;
            this.deleteDialogVisible = true;
        },

        addEvent() {
            this.$router.push({
                path: `/addEvent`
            })
        },
        editEventData(index, row) {
            this.$router.push({
                path: `/edit-event/${row.ID}`
            })

        },
        deletEvent(id) {
            const that = this;

            EMS.adminPost({
                    route: 'delete_event',
                    id: id,
                    ems_nonce: ajax_url.ems_nonce,
                })
                .then(response => {
                    this.deleteDialogVisible = false;
                    ElMessage({
                        showClose: true,
                        message: response.data.message,
                        type: 'success',
                    })
                    this.fetchData();
                })
                .fail(error => {})

            // jQuery.ajax({
            //     type: "POST",
            //     url: ajax_url.ajaxurl,
            //     dataType: 'json',
            //     data: {
            //         action: "ems_delete_event",
            //         id: row.ID,
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
        showSingleData(index, row) {
            this.$router.push({
                path: `/show-event/${row.ID}`
            })

        },
        fetchData() {
            // const that = this;
            // jQuery.ajax({
            //     type: "GET",
            //     url: ajax_url.ajaxurl,
            //     dataType: 'json',
            //     data: {
            //         action: "ems_get_event_data",
            //         type: 'fetch'
            //     },
            //     success: function (data) {
            //         that.events = data.data;
            //     }
            // });
            const that = this;
            EMS.adminGet({
                    route: 'get_eventData',
                    ems_nonce: ajax_url.ems_nonce,
                })
                .then(response => {
                    that.events = response.data.event_data;

                })
                .fail(error => {

                })

        },
    }
}
</script>

<style>
.pagination-block {
    margin-left: auto;
    margin-right: 0px;
    margin-top: 20px;

}
</style>
