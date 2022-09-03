
import { createWebHashHistory, createRouter } from "vue-router";
import AllEvents from "../admin/Views/AllEvents.vue";
import ViewEvent from "../admin/Views/ViewEvent.vue";
import EventCategories from "../admin/Views/EventCategories.vue";
import AddEvent from "../admin/Views/AddEvent.vue";
import EditEvent from "../admin/Views/EditEvent.vue";
import EventCategory from "../admin/Views/EventCategories.vue";
import AddEventCategory from "../admin/Views/AddEventCategory.vue";
import EditEventCategory from "../admin/Views/EditEventCategory.vue";
import EventOrganizer from "../admin/Views/EventOrganizer.vue";
import AddEventOrganizer from "../admin/Views/AddOrganizer.vue";
import EditEventOrganizer from "../admin/Views/EditEventOrganizer.vue";

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
        path: "/addEvent",
        name: "AddEvent",
        component: AddEvent,
    },
    {
        path: "/show-event/:eventID",
        name: "ViewEvent",
        component: ViewEvent,
    },
    {
        path: "/eventCategory",
        name: "EventCategory",
        component: EventCategory,
    },
    {
        path: "/addEventCategory",
        name: "AddEventCategory",
        component: AddEventCategory,
    },
    {
        path: "/eventCategory/:categoryID",
        name: "EditEventCategory",
        component: EditEventCategory,
    },
    {
        path: "/eventOrganizer",
        name: "EventOrganizer",
        component: EventOrganizer,
    },
    {
        path: "/addEventOrganizer",
        name: "AddEventOrganizer",
        component: AddEventOrganizer,
    },
    {
        path: "/eventOrganizer/:organizerID",
        name: "EditEventOrganizer",
        component: EditEventOrganizer,
    },
];

const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

export default router;