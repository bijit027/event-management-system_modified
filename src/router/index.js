
import { createWebHashHistory, createRouter } from "vue-router";
import AllEvents from "../admin/Views/AllEvents.vue";
import EventCategories from "../admin/Views/EventCategories.vue";
import EventOrganizers from "../admin/Views/EventOrganizers.vue";
import AddEvent from "../admin/Views/AddEvent.vue";

const routes = [
    {
        path: "/",
        name: "AllEvents",
        component: AllEvents,
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
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

export default router;