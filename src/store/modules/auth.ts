import axios from "../../axios";
import { Commit, Dispatch } from "vuex";

const baseURL = "/auth_user";

export default {
    namespaced: true,
    state: {
        user: {},
    },
    actions: {
        async user({ commit }: { commit: Commit }, payload = {}) {
            const { data } = await axios.get(`${baseURL}`);
            commit("SET_USER", data.data);
            return data.data;
        },
        async subscribe({ dispatch }: { dispatch: Dispatch }, payload = {}) {
            const { data } = await axios.put(`subscribe`, payload);
            return data;
        },
    },
    mutations: {
        SET_USER(state: any, data: any) {
            state.user = data;
        },
    },
    getters: {
        user(state: any) {
            return state.user;
        },
    },
};
