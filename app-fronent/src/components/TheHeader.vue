<script lang="ts" setup>
import { ref } from "vue";
import { DownOutlined, MenuOutlined } from "@ant-design/icons-vue";
import TheMenu from "./TheMenu.vue";

const open = ref<Boolean>(false);
const openUser = ref<Boolean>(false);

const showDrawer = () => {
  open.value = true;
};
const showDrawerUser = () => {
  openUser.value = true;
};
const onClose = () => {
  open.value = false;
};
const onCloseUser = () => {
  openUser.value = false;
};
</script>

<template>
  <div class="container-fluid">
    <div
      class="row text-white"
      style="background-color: #0c713d; padding: 1rem"
    >
      <div
        class="col-1 d-flex d-sm-none align-items-center justify-content-center cursor-pointer"
      >
        <span @click="showDrawer"><MenuOutlined /></span>
      </div>
      <div
        class="col-10 col-sm-9 d-flex align-items-center justify-content-center justify-content-sm-start"
      >
        <img
          src="../assets/loc.jpg"
          alt="Logo"
          height="34"
          width="34"
          class="ms-3 me-3"
        />
        <span class="d-none d-sm-flex">QUẢN TRỊ</span>
      </div>
      <div
        class="col-sm-3 d-none d-sm-flex align-items-center justify-content-end"
      >
        <a-dropdown :trigger="['click']">
          <a class="ant-dropdown-link cursor-pointer" @click.prevent>
            ADMIN
            <DownOutlined />
          </a>
          <template #overlay>
            <a-menu class="w-[120px] mt-2">
              <a-menu-item key="0">
                <a href="#">Đăng xuất</a>
              </a-menu-item>
            </a-menu>
          </template>
        </a-dropdown>
      </div>
      <div
        class="col-1 d-flex d-sm-none align-items-center justify-content-center cursor-pointer"
      >
        <span @click="showDrawerUser">X</span>
      </div>
    </div>
    <a-drawer
      :width="300"
      title="MENU"
      placement="left"
      :open="open"
      @close="onClose"
    >
      <template #extra> </template>
      <TheMenu />
    </a-drawer>
    <a-drawer
      :width="200"
      title="ADMIN "
      placement="right"
      :open="openUser"
      @close="onCloseUser"
    >
      <template #extra> </template>
      <p>ADMIN</p>
      <p>Some contents...</p>
      <p>Some contents...</p>
    </a-drawer>
  </div>
</template>
