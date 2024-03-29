import { defineStore } from "pinia";
import { ref } from "vue";

export const useMenu = defineStore("menuId", () => {
  const selectedKeys = ref<any[]>([]);
  const openKeys = ref<any[]>([]);
  function onSelectedKeys(data: any) {
    selectedKeys.value = data;
  }
  function onOpenKeys(data: any) {
    openKeys.value = data;
  }
  return {
    selectedKeys,
    openKeys,
    onSelectedKeys,
    onOpenKeys,
  };
});
