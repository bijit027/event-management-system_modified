<template>
    <el-card class="box-card input_card">
        <div class="close_button">
            <router-link to="/" tag="button">
                <el-button type="info">Back</el-button>
            </router-link>
        </div>
        <div class="container">
            <!-- <div class="wrap"> -->
            <el-form label-width="100px">
                <div class="form-item">
                    <el-form-item label="Event Title" class="required">
                        <el-col :span="8">
                            <el-input type="text" size="large" v-model="event.title" />
                            <small class="danger" v-if="errors.title">{{ errors.title }}</small>
                        </el-col>
                    </el-form-item>
                </div>
                <el-form-item label="Event Details">
                    <el-col :span="8">
                        <el-input type="textarea" v-model="event.details" />
                        <small class="danger" v-if="errors.details">{{ errors.details }}</small>
                    </el-col>
                </el-form-item>
                <el-form-item label="Category" class="required">
                    <el-col :span="8">
                        <el-select placeholder="Please select your category" v-model="event.category">
                            <el-option
                                v-for="value in category"
                                :key="value.term_id"
                                :label="value.name"
                                :value="value.term_id"
                            />
                        </el-select>
                        <small class="danger" v-if="errors.category">{{ errors.category }}</small>
                    </el-col>
                </el-form-item>
                <el-form-item label="Organizer" class="required">
                    <el-col :span="8">
                        <el-select placeholder="Select Organizer" v-model="event.organizer">
                            <el-option
                                v-for="value in organizer"
                                :key="value.ID"
                                :label="value.name"
                                :value="value.name"
                            />
                        </el-select>
                        <small class="danger" v-if="errors.organizer">{{ errors.organizer }}</small>
                    </el-col>
                </el-form-item>
                <el-form-item label=" Event Type">
                    <el-radio-group v-model="event.onlineEvent">
                        <el-radio label="Online" />
                        <el-radio label="Offline" />
                    </el-radio-group>
                    <small class="danger" v-if="errors.onlineEvent">{{ errors.onlineEvent }}</small>
                </el-form-item>
                <el-form-item label="Banner Url">
                    <el-col :span="8">
                        <el-input v-model="event.url" />
                        <small class="danger" v-if="errors.url">{{ errors.url }}</small>
                    </el-col>
                </el-form-item>

                <!-- <el-form-item label="Image upload">
                    <el-upload
                        class="avatar-uploader"
                        action="https://jsonplaceholder.typicode.com/posts/"
                        :show-file-list="false"
                        accept_x="image/png, image/jpeg"
                        :on-error="handleUploadError"
                        :on-success="handleUploadSuccess"
                    >

                      <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                        <img v-if="imageUrl" :src="imageUrl" class="avatar" />
                        <i v-else class="el-icon-plus avatar-uploader-icon">AS</i>
                    </el-upload>
                </el-form-item> -->

                <el-form-item label="">
                    <el-col :span="8">
                        <!-- <el-input type="file" ref="imageurl" id="image" v-model="event.image" @change="uploadImage" /> -->
                        <span>
                            {{ event.image ? "Change Logo: " : "Upload Logo: " }}
                            <img :src="event.image" alt="no image" width="60" height="40" />
                        </span>
                        <input ref="imageurl" class="imageurlinput" type="file" @input="uploadImage" />
                        <small class="danger" v-if="errors.url">{{ errors.url }}</small>
                    </el-col>
                </el-form-item>

                <el-form-item label="Start Date" class="required">
                    <el-col :span="8">
                        <el-date-picker
                            type="date"
                            placeholder="Pick a Date"
                            format="MMM D, YYYY"
                            value-format="MMM D, YYYY"
                            style="width: 100%"
                            v-model="event.startingDate"
                        />
                        <small class="danger" v-if="errors.startingDate">{{ errors.startingDate }}</small>
                    </el-col>
                </el-form-item>

                <el-form-item label="Start Time" class="required">
                    <el-col :span="8">
                        <el-time-picker
                            type="time"
                            placeholder="Pick a time"
                            format="HH:mm:ss"
                            value-format="HH:mm:ss"
                            style="width: 100%"
                            v-model="event.startingTime"
                        />
                        <small class="danger" v-if="errors.startingTime">{{ errors.startingTime }}</small>
                    </el-col>
                </el-form-item>

                <el-form-item label="End Date" class="required">
                    <el-col :span="8">
                        <el-date-picker
                            type="date"
                            placeholder="Pick a Date"
                            format="MMM D, YYYY"
                            value-format="MMM D, YYYY"
                            style="width: 100%"
                            v-model="event.endingDate"
                        />
                        <small class="danger" v-if="errors.endingDate">{{ errors.endingDate }}</small>
                    </el-col>
                </el-form-item>
                <el-form-item label="End Time" class="required">
                    <el-col :span="8">
                        <el-time-picker
                            type="time"
                            placeholder="Pick a time"
                            format="HH:mm:ss"
                            value-format="HH:mm:ss"
                            style="width: 100%"
                            v-model="event.endingTime"
                        />
                        <small class="danger" v-if="errors.endingTime">{{ errors.endingTime }}</small>
                    </el-col>
                </el-form-item>
                <el-form-item label="Location" class="required">
                    <el-col :span="8">
                        <el-input type="text" v-model="event.location" />
                        <small class="danger" v-if="errors.location">{{ errors.location }}</small>
                    </el-col>
                </el-form-item>
                <el-form-item label="Limit" class="required">
                    <el-col :span="8">
                        <el-input-number :min="1" v-model="event.limit" />
                        <small class="danger" v-if="errors.limit">{{ errors.limit }}</small>
                    </el-col>
                </el-form-item>
                <el-form-item label="Deadline" class="required">
                    <el-col :span="8">
                        <el-date-picker
                            type="date"
                            placeholder="Pick a Date"
                            format="MMM D, YYYY"
                            value-format="MMM D, YYYY"
                            style="width: 100%"
                            v-model="event.deadline"
                        />
                        <small class="danger" v-if="errors.deadline">{{ errors.deadline }}</small>
                    </el-col>
                </el-form-item>

                <el-form-item>
                    <el-button type="primary" @click="onSubmit">{{ button }}</el-button>
                </el-form-item>
            </el-form>
            <!-- </div> -->
        </div>
    </el-card>
</template>

<script>
export default {
    props: ["event", "errors", "button"],
    emits: ["form-submit"],

    data() {
        return {
            category: {},
            organizer: {},
            name: "",
            previewImage: null,
            imageUrl: "",
        };
    },

    mounted() {
        this.fetchCategory();
        this.fetchOrganizer();
    },

    methods: {
        // handleUploadSuccess(response) {
        //     this.event.image = response.data.file.url;
        //     console.log(this.event.image);
        // },
        // handleUploadError(error) {
        //     // this.$message.error(error.toString());
        // },
        fetchCategory() {
            const that = this;
            EMS.adminGet({
                route: "get_category_Data",
                ems_nonce: ajax_url.ems_nonce,
            })
                .then((response) => {
                    that.category = response.data.term_data;
                })
                .fail((error) => {
                    ElMessage.error(error.responseJSON.data.error);
                });
        },
        fetchOrganizer() {
            const that = this;
            EMS.adminGet({
                route: "get_organizer_Data",
                ems_nonce: ajax_url.ems_nonce,
            })
                .then((response) => {
                    that.organizer = response.data.term_data;
                })
                .fail((error) => {
                    ElMessage.error(error.responseJSON.data.error);
                });
        },
        onSubmit() {
            this.$emit("form-submit", this.event);
        },
        uploadImage(e) {
            let input = this.$refs.imageurl;
            let file = input.files;
            if (file && file[0]) {
                let reader = new FileReader();
                reader.readAsDataURL(file[0]);
                reader.onload = (e) => {
                    this.event.image = e.target.result;
                };
            }

            // const image = e;
            // console.log(image);

            // $this = $(this);
            // const file_data = $(this).prop("image")[0];
            // console.log(this.event.image);
            // console.log(e);
            // const image = e.target.files[0];
            // var tmppath = URL.createObjectURL(event.target.files[0]);

            // var tmppath = document.getElementById("image").value;
            // console.log(tmppath);
            // const form_data = new FormData();
            // form_data.append("file", image);
            // // console.log(form_data);
            // // this.image = new FormData();
            // // this.image.append("file", file);
            // this.event.image = e.target.files[0];
            // console.log(this.event.image);
            // const reader = new FileReader();
            // reader.readAsDataURL(image);
            // reader.onload = (e) => {
            //     this.previewImage = e.target.result;
            //     this.event.image = this.previewImage;
            //     console.log(this.event.image);
            // };
        },
    },
};
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

.input_card {
    width: 40%;
    margin: auto;
    margin-top: 50px;
}

.danger {
    color: red;
}
</style>
