import { createApp } from "vue";
import { createPinia } from "pinia";
import "./style.css";
import App from "./App.vue";
import router from "./routers/index.tsx";
import {
  Drawer,
  Table,
  Button,
  message,
  List,
  Menu,
  Card,
  Avatar,
  Input,
  Select,
  Checkbox,
  Modal,
  Dropdown,
} from "ant-design-vue";
import "ant-design-vue/dist/reset.css";
import "bootstrap/dist/css/bootstrap-grid.min.css";
import "bootstrap/dist/css/bootstrap-utilities.min.css";
const app = createApp(App);
app.use(router);
app.use(Button);
app.use(Drawer);
app.use(List);
app.use(Menu);
app.use(Card);
app.use(Table);
app.use(Avatar);
app.use(Input);
app.use(Select);
app.use(Checkbox);
app.use(Modal);
app.use(Dropdown);
app.use(createPinia());
app.mount("#app");
app.config.globalProperties.$message = message;
