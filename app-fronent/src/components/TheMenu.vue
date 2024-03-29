<script setup lang="ts">
import { storeToRefs } from "pinia";
import { useMenu } from "../store/use-menu";
import {
  UserOutlined,
  SettingOutlined,
  TagOutlined,
} from "@ant-design/icons-vue";

const storeMenu = useMenu();
const { openKeys, selectedKeys } = storeToRefs(storeMenu);
</script>

<template>
  <a-menu
    v-model:openKeys="openKeys"
    v-model:selectedKeys="selectedKeys"
    mode="inline"
  >
    <a-menu-item key="admin-users">
      <router-link :to="{ name: 'admin-users' }">
        <span class="d-flex align-items-center">
          <UserOutlined class="me-1" /> Tài Khoản</span
        >
      </router-link>
    </a-menu-item>
    <a-menu-item key="admin-roles">
      <router-link :to="{ name: 'admin-roles' }">
        <span class="d-flex align-items-center">
          <TagOutlined class="me-1" />Vai Trò</span
        >
      </router-link>
    </a-menu-item>
    <a-menu-item key="admin-settings">
      <router-link :to="{ name: 'admin-settings' }">
        <span class="d-flex align-items-center">
          <SettingOutlined class="me-1" /> Cài Đặt</span
        >
      </router-link>
    </a-menu-item>
  </a-menu>
</template>
