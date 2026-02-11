import { createStore } from "vuex";
import signup from "./signup.js";
import events from "./../admin/events.js";

export default new createStore({
    strict: true,
    state: {
        generalMessages: {},
    },
    mutations: {
        setGeneralMessages(state, payload) {
            state.generalMessages = payload || {};
        },
    },
    modules: {
        signup,
        events,
    },
});
