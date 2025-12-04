import { createStore } from "vuex";
import signup from "./signup.js";
import events from "./../admin/events.js";

export default new createStore({
    strict: true,
    modules: {
        signup,
        events
    },
});
