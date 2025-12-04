require("./bootstrap");

import { createApp } from "vue";
import router from "./router";
import store from "./store/index";
import AppLayout from "./admin/Layouts/App.vue";

import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";

const app = createApp({})
    .use(store)
    .use(router)
    .use(VueSweetalert2)
    .component("AppLayout", AppLayout)
    .mount("#app");
