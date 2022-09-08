<template>
<el-card class="box-card">
    <div class="container">
        <div class="wrap">
            <el-form label-width="100px">
                <div class="form-item">
                    <el-form-item label="Event Title" class="required" prop="title" show-message="false">
                        <el-col>
                            <el-input type="text" size="large" v-model="event.title" />
                            <small class="danger" v-if="errors.title">{{ errors.title }}</small>
                        </el-col>
                    </el-form-item>
                </div>
                <el-form-item label="Event Details" prop="details">
                    <el-col>
                        <el-input type="textarea" v-model="event.details" />
                    </el-col>
                </el-form-item>
                <el-form-item label="Category" class="required" prop="category">
                    <el-col :span="8">
                        <el-select placeholder="Please select your category" v-model="event.category">
                            <el-option v-for="value in category" :key="value.term_id" :label="value.name" :value="value.term_id" />
                        </el-select>
                        <small class="danger" v-if="errors.category">{{ errors.category }}</small>
                    </el-col>
                </el-form-item>
                <el-form-item label="Organizer" class="required" prop="organizer">
                    <el-col :span="8">
                        <el-select placeholder="Select Organizer" v-model="event.organizer">
                            <el-option v-for="value in organizer" :key="value.ID" :label="value.name" :value="value.name" />
                        </el-select>
                        <small class="danger" v-if="errors.organizer">{{ errors.organizer }}</small>
                    </el-col>
                </el-form-item>
                <el-form-item label="Online Event" prop="onlineEvent">
                    <el-radio-group v-model="event.onlineEvent">
                        <el-radio label="Yes" />
                        <el-radio label="No" />

                    </el-radio-group>
                    <small class="danger" v-if="errors.onlineEvent">{{ errors.onlineEvent }}</small>
                </el-form-item>
                <el-form-item label="Banner Url" prop="url">
                    <el-col :span="8">
                        <el-input v-model="event.url" />
                    </el-col>
                </el-form-item>

                <el-form-item label="Start Date" class="required" prop="startingDate">
                    <el-col :span="8">
                        <el-date-picker type="date" placeholder="Pick a Date" format="YYYY/MM/DD" value-format="YYYY-MM-DD" style="width: 100%" v-model="event.startingDate" />
                        <small class="danger" v-if="errors.startingDate">{{ errors.startingDate }}</small>
                    </el-col>

                </el-form-item>

                <el-form-item label="Start Time" class="required" prop="startingTime">

                    <el-col :span="8">
                        <el-time-picker type="time" placeholder="Pick a time" format="HH:mm:ss" value-format="HH:mm:ss" style="width: 100%" v-model="event.startingTime" />
                        <small class="danger" v-if="errors.startingTime">{{ errors.startingTime }}</small>
                    </el-col>

                </el-form-item>

                <el-form-item label="End Date" class="required" prop="endingDate">
                    <el-col :span="8">
                        <el-date-picker type="date" placeholder="Pick a Date" format="YYYY/MM/DD" value-format="YYYY-MM-DD" style="width: 100%" v-model="event.endingDate" />
                        <small class="danger" v-if="errors.endingDate">{{ errors.endingDate }}</small>
                    </el-col>
                </el-form-item>
                <el-form-item label="End Time" class="required" prop="endingTime">
                    <el-col :span="8">
                        <el-time-picker type="time" placeholder="Pick a time" format="HH:mm:ss" value-format="HH:mm:ss" style="width: 100%" v-model="event.endingTime" />
                        <small class="danger" v-if="errors.endingTime">{{ errors.endingTime }}</small>
                    </el-col>

                </el-form-item>
                <el-form-item label="Location" class="required" prop="location">
                    <el-col :span="8">
                        <el-input type="text" v-model="event.location" />
                        <small class="danger" v-if="errors.location">{{ errors.location }}</small>
                    </el-col>
                </el-form-item>
                <el-form-item label="Limit" prop="limit">
                    <el-col :span="8">
                        <el-input-number :min="1" v-model="event.limit" />
                    </el-col>
                </el-form-item>
                <el-form-item label="Deadline" class="required" prop="deadline">
                    <el-col :span="8">
                        <el-date-picker type="date" placeholder="Pick a Date" format="YYYY/MM/DD" value-format="YYYY-MM-DD" style="width: 100%" v-model="event.deadline" />
                        <small class="danger" v-if="errors.deadline">{{ errors.deadline }}</small>
                    </el-col>
                </el-form-item>

                <el-form-item>
                    <el-button type="primary" @click="onSubmit">{{ button }}</el-button>
                </el-form-item>
            </el-form>
        </div>
    </div>
</el-card>
</template>

<script>
export default {

    props: ['event', 'errors', 'button'],
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
            const that = this;
            EMS.adminGet({
                    route: 'get_category_Data',
                    ems_nonce: ajax_url.ems_nonce,
                })
                .then(response => {
                    that.category = response.data.term_data;
                })
                .fail(error => {
                    ElMessage.error(error.responseJSON.data.error)
                })
        },
        fetchOrganizer() {
            const that = this;
            EMS.adminGet({
                    route: 'get_organizer_Data',
                    ems_nonce: ajax_url.ems_nonce,
                })
                .then(response => {
                    that.organizer = response.data.term_data;
                })
                .fail(error => {
                    ElMessage.error(error.responseJSON.data.error)
                })

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
