<template>
<el-main>
    <div>
        <h2>ALL Organizers</h2>
    </div>
    <el-button type="primary" @click="addOrganizeer()">Add Organizer</el-button>

    <el-table :data="displayData" style="width: 100%">
        <el-table-column label="ID" prop="term_id" />
        <el-table-column label="Name" prop="name" />
        <el-table-column align="right">
            <template #default="scope">
                <el-button size="small" @click="editOrganizer(scope.$index, scope.row)">Edit</el-button>
                <el-button size="small" type="danger" @click="confirmDeleteMessage(scope.row)">Delete</el-button>
            </template>
        </el-table-column>
    </el-table>
    <el-row>

        <!--Delete event Confimation Modal-->
        <el-dialog title="Are You Sure, You want to delete this organizer?" v-model="deleteDialogVisible" :show-close="false" width="40%">
            <div class="modal_body">
                <p>Organizer ID: {{ deleteingOrganizer.term_id }}? </p>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button type="danger" @click="deleteDialogVisible = false">Cancel</el-button>
                <el-button type="primary" @click="deleteOrganizer(deleteingOrganizer.term_id)">Confirm</el-button>
            </span>
        </el-dialog>

        <div class="pagination-block">
            <el-pagination background layout="sizes,total,prev, pager, next,jumper" @current-change="handleCurrentChange" @size-change="handleSizeChange" :page-size="pageSize" :page-sizes="[5,10,15,20]" :total="organizers.length" />
        </div>
    </el-row>
</el-main>
</template>

<script>
import OrganizerInputForm from "../Components/OrganizerInputForm.vue";
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
                button: 'Create'

            },
            errorMessage: null,
            showSuccess: '',
            showError: '',
            page: 1,
            pageSize: 5,
            deleteingOrganizer: {},
            deleteDialogVisible: false,
        }
    },

    mounted() {

        this.fetchOrganizerData();
    },
    computed: {
        displayData() {
            if (!this.organizers || this.organizers.length === 0) return [];
            return this.organizers.slice(this.pageSize * this.page - this.pageSize, this.pageSize * this.page)
        }
    },
    methods: {
        confirmDeleteMessage(organizer) {
            this.deleteingOrganizer = organizer;
            this.deleteDialogVisible = true;
        },
        addOrganizeer() {
            this.$router.push({
                path: `/addEventOrganizer`
            })
        },
        handleCurrentChange(val) {
            this.page = val;
        },
        handleSizeChange(val) {
            this.pageSize = val;
        },
        editOrganizer(index, row) {
            this.$router.push({
                path: `/eventOrganizer/${row.term_id}`
            })

        },
        fetchOrganizerData() {
            const that = this;
            EMS.adminGet({
                    route: 'get_organizer_Data',
                    ems_nonce: ajax_url.ems_nonce,
                })
                .then(response => {
                    that.organizers = response.data.term_data;
                })
                .fail(error => {
                    ElMessage.error(error.responseJSON.data.error);
                })

        },

        deleteOrganizer(id) {
            const that = this;
            EMS.adminPost({
                    route: 'delete_organizer',
                    id: id,
                    ems_nonce: ajax_url.ems_nonce,
                })
                .then(response => {
                    this.fetchOrganizerData();
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

        },
    }
}
</script>

<style>
.wrap {
    width: 100%;
}

.pagination-block {
    margin-left: auto;
    margin-right: 0px;
}
</style>
