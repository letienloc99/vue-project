<script lang="ts" setup>
import TheHeader from "../components/TheHeader.vue";
import TheMenu from "../components/TheMenu.vue";
</script>

<template>
  <TheHeader />
  <div class="container-fluid mt-3">
    <div class="row">
      <div class="col-sm-3 d-none d-sm-flex">
        <a-list bordered class="w-full">
          <TheMenu />
          <template #header>
            <div>BẢNG MENU</div>
          </template>
        </a-list>
      </div>
      <div class="col-sm-9 col-12">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>
