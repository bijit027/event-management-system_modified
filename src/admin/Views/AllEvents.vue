<template>
	<el-main>
		<div>
			<h2>ALL Events</h2>
		</div>
		<div class="ems_allEvents_heading">
			<el-button type="primary" @click="addEvent()">Add Event</el-button>

			<div class="shortcode_tooltip">
				<el-tooltip effect="dark" content="Click to copy shortcode" title="Click to copy shortcode" placement="top">
					<code class="copy" :data-clipboard-text="`[event-management]`"> Use this shortcode [event-management] </code>
				</el-tooltip>
			</div>
		</div>
		<el-row>
			<el-table :data="displayData" style="width: 100%">
				<el-table-column label="ID" prop="ID" />
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
		<el-row v-if="events.length > 10">
			<div class="pagination-block">
				<el-pagination
					background
					layout="total,sizes,prev, pager, next,jumper"
					@current-change="handleCurrentChange"
					@size-change="handleSizeChange"
					:page-size="pageSize"
					:page-sizes="[10, 20, 30, 40]"
					:total="events.length"
				/>
			</div>
		</el-row>

		<!--Delete event Confimation Modal-->
		<el-dialog
			title="Are You Sure, You want to delete this event?"
			v-model="deleteDialogVisible"
			:show-close="false"
			width="40%"
		>
			<div class="modal_body">
				<p>Event ID: {{ deleteingForm.ID }}?</p>
			</div>
			<span slot="footer" class="dialog-footer">
				<el-button type="danger" @click="deleteDialogVisible = false">Cancel</el-button>
				<el-button type="primary" @click="deletEvent(deleteingForm.ID)">Confirm</el-button>
			</span>
		</el-dialog>
	</el-main>
</template>

<script>
	import Clipboard from "clipboard";
	import { ElButton, ElMessage } from "element-plus";
	export default {
		components: {
			ElButton,
		},
		data() {
			return {
				loading: false,
				events: [],
				errorMessage: null,
				showSuccess: "",
				showError: "",
				page: 1,
				pageSize: 10,
				deleteingForm: {},
				deleteDialogVisible: false,
			};
		},

		mounted() {
			this.fetchData();
			var clipboard = new Clipboard(".copy");
			clipboard.on("success", (e) => {
				this.$message({
					message: "Copied to Clipboard!",
					type: "success",
				});
			});
		},
		computed: {
			displayData() {
				if (!this.events || this.events.length === 0) return [];
				return this.events.slice(this.pageSize * this.page - this.pageSize, this.pageSize * this.page);
			},
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
					path: `/addEvent`,
				});
			},
			editEventData(index, row) {
				this.$router.push({
					path: `/edit-event/${row.ID}`,
				});
			},
			deletEvent(id) {
				const that = this;

				EMS.adminPost({
					route: "delete_event",
					id: id,
					ems_nonce: ajax_url.ems_nonce,
				})
					.then((response) => {
						this.fetchData();
						ElMessage({
							showClose: true,
							message: response.data.message,
							type: "success",
						});
						this.deleteDialogVisible = false;
					})
					.fail((error) => {
						ElMessage.error(error.responseJSON.data.error);
						this.deleteDialogVisible = false;
					});
			},
			showSingleData(index, row) {
				this.$router.push({
					path: `/show-event/${row.ID}`,
				});
			},
			fetchData() {
				const that = this;
				EMS.adminGet({
					route: "get_event_data",
					ems_nonce: ajax_url.ems_nonce,
					category: "",
				})
					.then((response) => {
						that.events = response.data.event_data;
					})
					.fail((error) => {
						ElMessage.error(error.responseJSON.data.error);
					});
			},
		},
	};
</script>

<style>
	.pagination-block {
		margin-left: auto;
		margin-right: 0px;
		margin-top: 20px;
	}

	.el-button {
		margin-bottom: 10px;
	}

	.message {
		background-color: white;
		border: 1px solid black;
		display: inline;
		margin-left: 40px;
	}
	.ems_allEvents_heading {
		display: flex;
		justify-content: space-between;
	}
	.shortcode_tooltip {
		display: flex;
		flex-wrap: wrap;
		align-content: center;
	}
</style>
