<script lang="ts" setup>
import { useMenu } from "../../../store/use-menu.ts";
const storeMenu = useMenu();
storeMenu.onSelectedKeys(["admin-roles"]);
</script>

<template>đây là trang ql Roles</template>
