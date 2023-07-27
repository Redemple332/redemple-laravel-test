import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import Antd from "ant-design-vue";
import "ant-design-vue/dist/antd.less";
import {
    PlusOutlined,
    DownOutlined,
    DeleteOutlined,
    FormOutlined,
} from "@ant-design/icons-vue";
import DataTable from "./components/DataTable.vue";

const app = createApp(App);
app.use(store);
app.use(router);
app.use(Antd);
app.component("PlusOutlined", PlusOutlined);
app.component("DownOutlined", DownOutlined);
app.component("FormOutlined", FormOutlined);
app.component("DeleteOutlined", DeleteOutlined);
app.component("DataTable", DataTable);

app.mount("#app");
