import Vue from 'vue';
import { createApp } from "vue";
import EMS from './EMS';
window.EMS = new EMS();
import router from "./router";
import App from "./App.vue";
import ElementPlus from "element-plus";
import "./css/admin/index.css"

createApp(App).use(router).use(ElementPlus).mount("#ems-admin-app");