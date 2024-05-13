<script lang="ts" setup>
import axios from "axios";
import { useMenu } from "../../../store/use-menu.ts";
import { onMounted, ref } from "vue";
import { columns } from "./user.data.ts";
import { message } from "ant-design-vue";
const storeMenu = useMenu();
storeMenu.onSelectedKeys(["admin-users"]);
const users = ref([]);
const index = () => {
  axios
    .get("http://localhost:8080/api/user", {})
    .then((response) => {
      users.value = response.data?.result || [];
    })
    .catch((error) => {
      console.log(error);
      if (error) message.error("Đăng nhập không thành công!!");
    });
};
onMounted(() => {
  index();
});
</script>
<template>
  <a-card title="Tài khoản" style="width: 100%">
    <div class="row">
      <div class="col-12 flex justify-end">
        <router-link :to="{ name: 'admin-create' }">
          <a-button type="primary" class="mb-2 mr-0">
            <span>Tạo mới</span>
          </a-button>
        </router-link>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <a-table :dataSource="users" :columns="columns" :scroll="{ x: 576 }" />
      </div>
    </div>
  </a-card>
</template>
