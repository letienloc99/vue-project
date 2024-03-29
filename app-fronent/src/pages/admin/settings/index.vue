<script lang="ts" setup>
import { useMenu } from "../../../store/use-menu";

const storeMenu = useMenu();
storeMenu.onSelectedKeys(["admin-settings"]);
</script>

<template>đây là trang Settings</template>
