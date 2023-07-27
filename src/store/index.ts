import { createStore } from "vuex";
import User from "./modules/user";
import Auth from "./modules/auth";
export default createStore({
    state: {},
    getters: {},
    mutations: {},
    actions: {},
    modules: { User, Auth },
});
