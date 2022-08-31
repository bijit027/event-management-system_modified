
import { createWebHashHistory, createRouter } from "vue-router";
import AllEvents from "../admin/Views/AllEvents.vue";
import ViewEvent from "../admin/Views/ViewEvent.vue";
import EventCategories from "../admin/Views/EventCategories.vue";
import EventOrganizers from "../admin/Views/EventOrganizers.vue";
import AddEvent from "../admin/Views/AddEvent.vue";
import EditEvent from "../admin/Views/EditEvent.vue";

const routes = [
    {
        path: "/",
        name: "AllEvents",
        component: AllEvents,
    },
    {
        path: "/edit-event/:eventID",
        name: "EditEvent",
        component: EditEvent,
    },
    {
        path: "/categories",
        name: "EventCategories",
        component: EventCategories,
    },
    {
        path: "/organizers",
        name: "EventOrganizers",
        component: EventOrganizers,
    },
    {
        path: "/addEvent",
        name: "AddEvent",
        component: AddEvent,
    },
    {
        path: "/show-event/:eventID",
        name: "ViewEvent",
        component: ViewEvent,
    },
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

export default router;