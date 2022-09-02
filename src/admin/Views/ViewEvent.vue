<template>
<div class="container">
    <el-row>
        <div class="description">
            <el-card>

                <img :src="value.url" class="image" />
                <el-descriptions title="Event Information">
                    <el-descriptions-item label="Title:"><span class="event_value">{{value.title}}</span></el-descriptions-item>
                    <el-descriptions-item label="Details:"><span class="event_value">{{value.details}}</span></el-descriptions-item>
                    <el-descriptions-item label="Category:"><span class="event_value">{{value.category}}</span></el-descriptions-item>
                    <el-descriptions-item label="Organizer:"><span class="event_value">{{value.organizer}}</span></el-descriptions-item>
                    <el-descriptions-item label="Online Event:"><span class="event_value">{{value.onlineEvent}}</span></el-descriptions-item>
                    <el-descriptions-item label="Starting Date:"><span class="event_value">{{value.startingDate}}</span></el-descriptions-item>
                    <el-descriptions-item label="Starting Time:"><span class="event_value">{{value.startingTime}}</span></el-descriptions-item>
                    <el-descriptions-item label="Ending Date:"><span class="event_value">{{value.endingDate}}</span></el-descriptions-item>
                    <el-descriptions-item label="Ending Time:"><span class="event_value">{{value.endingTime}}</span></el-descriptions-item>
                    <el-descriptions-item label="Location:"><span class="event_value">{{value.location}}</span></el-descriptions-item>
                    <el-descriptions-item label="Limit:"><span class="event_value">{{value.limit}}</span></el-descriptions-item>
                    <el-descriptions-item label="Deadline:"><span class="event_value">{{value.deadline}}</span></el-descriptions-item>
                </el-descriptions>
            </el-card>
        </div>
    </el-row>
</div>
</template>

<script>
export default {
    data() {
        return {
            eventID: this.$route.params.eventID,
            event: {},
            value: {}
        }
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        fetchData() {

            const that = this;
            EMS.adminGet({
                    route: 'get_single_eventData',
                    id: that.eventID,
                    ems_nonce: ajax_url.ems_nonce,
                })
                .then(response => {
                    that.event = response.data.single_event_data;
                    that.value = JSON.parse(that.event.eventData);

                })
                .fail(error => {
                     ElMessage.error(error.responseJSON.data.error)
                })

        }
    }

}
</script>

<style scoped>
.time {
    font-size: 12px;
    color: #999;
}

.bottom {
    margin-top: 13px;
    line-height: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.button {
    padding: 0;
    min-height: auto;
}

.image {
    width: 100%;
    display: block;
}

.container {
    margin-left: 25%;
    margin-top: 100px
}

.title {
    float: left;

}

.event_value {
    color: black;
    font-weight: bold;
    margin-left: auto;
}

.description {
    width: 60%
}
</style>
