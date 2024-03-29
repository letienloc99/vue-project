import { TableProps } from "ant-design-vue";
import { computed, h } from "vue";
import { EditOutlined } from "@ant-design/icons-vue";
import { RouterLink } from "vue-router";
export const columns = computed<TableProps["columns"]>(() => [
  {
    title: "Id",
    dataIndex: "id",
    fixed: "left",
  },
  {
    title: "Ảnh đại diện",
    dataIndex: "avatar",
    customRender: ({ text, record }) => {
      return h("img", {
        src: record.avatar ? `/public/${record.avatar}` : "/public/default.png",
        class: "w-[50px] h-full object-contain",
      });
    },
  },
  {
    title: "Tên",
    dataIndex: "name",
  },
  {
    title: "Tên đầy đủ",
    dataIndex: "user_name",
  },
  {
    title: "Email",
    dataIndex: "email",
  },
  {
    title: "Trạng thái",
    dataIndex: "status",
    customRender: ({ text, record }) => {
      const props =
        record.status == "Hoạt động" ? "text-green-500" : "text-red-500";
      return h("div", { class: props }, text);
    },
  },
  {
    title: "Vai trò",
    dataIndex: "department",
  },
  {
    title: "Công cụ",
    dataIndex: "",
    customRender: ({ text, record }) => {
      return h(
        "div",
        { class: "text-blue-700 text-center" },
        h(RouterLink, { to: `users/${record.id}/update` }, h(EditOutlined))
      );
    },
    align: "center",
  },
]);
