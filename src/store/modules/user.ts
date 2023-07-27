import axios from "../../axios";
import { Commit, Dispatch } from "vuex";

const baseURL = "/users";

export default {
    namespaced: true,
    state: {
        data: [],
        item: {},
        fields: [
            { title: "Username", dataIndex: "username" },
            { title: "Email", dataIndex: "email" },
            { title: "Phone Number", dataIndex: "phone" },
            { title: "Is Subscribe", slots: { customRender: "is_subscribe" } },
            { title: "Action", slots: { customRender: "action" } },
        ],
        status: "loading",
    },
    actions: {
        async index({ commit }: { commit: Commit }, payload = {}) {
            commit("SET_STATUS", "loading");
            const { data } = await axios.get(`${baseURL}`, {
                params: { ...payload },
            });
            commit("SET_ITEMS", data);
            commit("SET_STATUS", "completed");
            return data;
        },

        async store({ dispatch }: { dispatch: Dispatch }, payload = {}) {
            const { data } = await axios.post(`${baseURL}`, payload);
            return data;
        },

        async update(
            { dispatch }: { dispatch: Dispatch },
            payload = { id: "" }
        ) {
            const { data } = await axios.put(
                `${baseURL}/${payload.id}`,
                payload
            );
            dispatch("index");
            return data;
        },

        async destroy(
            { dispatch }: { dispatch: Dispatch },
            payload = { id: "", message: "" }
        ) {
            const { data } = await axios.delete(`${baseURL}/${payload.id}`, {});
            dispatch("index");
            return data;
        },

        async show({ commit }: { commit: Commit }, id = "") {
            const { data } = await axios.get(`${baseURL}/${id}`);
            return data;
        },
    },
    mutations: {
        SET_ITEMS(state: any, data: any) {
            state.data = data.data;
        },
        SET_STATUS(state: any, payload: string) {
            state.status = payload;
        },
    },
    getters: {
        items(state: any) {
            return state.data;
        },
        fields(state: any) {
            return state.fields;
        },
        status(state: any) {
            return state.status;
        },
    },
};
