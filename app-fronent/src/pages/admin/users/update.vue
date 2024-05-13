<script lang="ts" setup>
import axios from "axios";
import { useMenu } from "../../../store/use-menu";
import { onMounted, ref, reactive, toRefs, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import { message } from "ant-design-vue";

const storeMenu = useMenu();
storeMenu.onSelectedKeys(["admin-users"]);
const loading = ref<boolean>(false);
const router = useRouter();
const route = useRoute();
const open = ref<boolean>(false);
const errors = ref();
const change_password = ref<boolean>(false);
const user_status = ref([]);
const department = ref([]);
const file = ref([]);
const selectedImage = ref();
const users = reactive({
  user_name: "",
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
  department_id: [],
  status_id: [],
  login_at: "",
  change_password_at: "",
  avatar: "",
});
const {
  user_name,
  name,
  email,
  password,
  password_confirmation,
  department_id,
  status_id,
  login_at,
  change_password_at,
  avatar,
} = toRefs(users);
watch(
  [
    user_name,
    name,
    email,
    password,
    password_confirmation,
    department_id,
    status_id,
  ],
  () => {
    if (
      user_name.value !== "" ||
      name.value !== "" ||
      email.value !== "" ||
      password.value !== "" ||
      password_confirmation.value !== "" ||
      department_id.value.length !== 0 ||
      status_id.value.length !== 0
    ) {
      errors.value = "";
    }
  }
);
const index = () => {
  axios
    .get("http://localhost:8080/api/user/create")
    .then((response) => {
      user_status.value = response.data?.result.status;
      department.value = response.data?.result.department;
    })
    .catch((error) => {
      console.log(error);
    });
};
const get = () => {
  axios
    .get(`http://localhost:8080/api/user/${route.params.id}`)
    .then((response) => {
      user_name.value = response?.data?.user_name;
      name.value = response?.data?.name;
      email.value = response?.data?.email;
      department_id.value = response?.data?.department_id;
      status_id.value = response?.data?.status_id;
      change_password_at.value = response?.data?.change_password_at;
      avatar.value = response?.data?.avatar;
    })
    .catch(() => {
      message.error("Lấy thông tin thất bại");
    });
};
const updateUser = () => {
  axios
    .put(`http://localhost:8080/api/user/${route.params.id}/update`, users)
    .then(function (response) {
      if (response) {
        message.success("Sửa thông tin thành công");
        router.push("/admin/users");
      }
    })
    .catch(function (error) {
      errors.value = error?.response?.data?.errors;
    });
};
onMounted(() => {
  index();
  get();
});
const filterOption = (input: string, option: any) => {
  return option.label.toLowerCase().indexOf(input.toLowerCase()) >= 0;
};

const showModal = () => {
  open.value = true;
};
const handleFileChange = (event: any) => {
  const fileSelect = event.target.files[0];
  if (fileSelect) {
    file.value = fileSelect;
    const reader = new FileReader();
    reader.onload = () => {
      selectedImage.value = reader.result;
    };
    reader.readAsDataURL(fileSelect);
  }
};
const handleOk = () => {
  loading.value = true;
  axios
    .delete(`http://localhost:8080/api/user/${route.params.id}/delete`)
    .then(function (response) {
      if (response) {
        message.success("Xóa tài khoản thành công");
        loading.value = false;
        router.push("/admin/users");
      }
    })
    .catch(function (error) {
      console.log(error);
    });
};
</script>

<template>
  <form @submit.prevent="updateUser()">
    <a-card title="Cập nhật tài khoản" style="width: 100%">
      <div class="row">
        <div class="col-12 flex justify-end">
          <a-button type="primary" class="mb-2 mr-0" danger @click="showModal">
            <span>Xóa tài khoản</span>
          </a-button>
        </div>
      </div>
      <div class="row mb-3">
        <div class="col-12 col-sm-4 mb-3">
          <div class="row">
            <div class="col-12 d-flex justify-content-center mb-3">
              <a-avatar shape="square" :size="200">
                <template #icon>
                  <img
                    v-if="!selectedImage && !avatar"
                    src="../../../assets/default.png"
                    alt="Avatar"
                  />
                  <img
                    v-if="!selectedImage && avatar"
                    :src="avatar"
                    alt="Avatar"
                  />
                  <img v-if="selectedImage" :src="selectedImage" alt="Avatar" />
                </template>
              </a-avatar>
            </div>

            <input
              type="file"
              ref="fileInput"
              style="display: none"
              @change="handleFileChange"
            />
            <div class="col-12 d-flex justify-content-center">
              <a-button type="primary" @click="$refs.fileInput.click()">
                <span>Chọn ảnh</span>
              </a-button>
            </div>
          </div>
        </div>

        <div class="col-12 col-sm-8">
          <div class="row mb-3">
            <div class="col-12 col-sm-3 text-start text-sm-end">
              <label>
                <span class="text-danger me-1">*</span>
                <span :class="errors && errors?.status_id ? 'text-red-500' : ''"
                  >Trạng thái:</span
                >
              </label>
            </div>

            <div class="col-12 col-sm-5">
              <a-select
                show-search
                placeholder="Tình trạng"
                style="width: 100%"
                :options="user_status"
                :filter-option="filterOption"
                allow-clear
                v-model:value="status_id"
                :class="
                  errors && errors?.status_id
                    ? 'border-2 border-solid border-red-700 rounded-md'
                    : ''
                "
              ></a-select>
              <div
                v-if="errors && errors?.status_id"
                :class="{
                  'text-red-500': errors?.status_id[0],
                }"
                class="w-100"
              >
                {{ errors?.status_id[0] }}
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-12 col-sm-3 text-start text-sm-end">
              <label>
                <span class="text-danger me-1">*</span>
                <span :class="errors && errors?.user_name ? 'text-red-500' : ''"
                  >Tên Tài khoản:</span
                >
              </label>
            </div>

            <div class="col-12 col-sm-5">
              <a-input
                placeholder="Tên Tài khoản"
                allow-clear
                v-model:value="user_name"
                :class="
                  errors && errors?.user_name
                    ? 'border-2 border-solid border-red-700 rounded-md'
                    : ''
                "
              />
              <div
                v-if="errors && errors?.user_name"
                :class="{
                  'text-red-500': errors && errors?.user_name,
                }"
                class="w-100"
              >
                {{ errors?.user_name[0] }}
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-12 col-sm-3 text-start text-sm-end">
              <label>
                <span class="text-danger me-1">*</span>
                <span :class="errors && errors?.name ? 'text-red-500' : ''"
                  >Họ và Tên:</span
                >
              </label>
            </div>

            <div class="col-12 col-sm-5">
              <a-input
                placeholder="Họ và Tên"
                allow-clear
                v-model:value="name"
                :class="
                  errors && errors?.name
                    ? 'border-2 border-solid border-red-700 rounded-md'
                    : ''
                "
              />
              <div
                v-if="errors && errors?.name"
                :class="{
                  'text-red-500': errors && errors?.name,
                }"
                class="w-100"
              >
                {{ errors?.name[0] }}
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-12 col-sm-3 text-start text-sm-end">
              <label>
                <span class="text-danger me-1">*</span>
                <span :class="errors && errors?.email ? 'text-red-500' : ''"
                  >Email:</span
                >
              </label>
            </div>

            <div class="col-12 col-sm-5">
              <a-input
                placeholder="Email"
                allow-clear
                v-model:value="email"
                :class="
                  errors && errors?.email
                    ? 'border-2 border-solid border-red-700 rounded-md'
                    : ''
                "
              />
              <div
                v-if="errors && errors?.email"
                :class="{
                  'text-red-500': errors && errors?.email,
                }"
                class="w-100"
              >
                {{ errors?.email[0] }}
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-12 col-sm-3 text-start text-sm-end">
              <label>
                <span class="text-danger me-1">*</span>
                <span
                  :class="errors && errors?.department_id ? 'text-red-500' : ''"
                  >Phòng ban:</span
                >
              </label>
            </div>

            <div class="col-12 col-sm-5">
              <a-select
                show-search
                placeholder="Phòng ban"
                style="width: 100%"
                :options="department"
                :filter-option="filterOption"
                allow-clear
                v-model:value="department_id"
                :class="
                  errors && errors?.department_id
                    ? 'border-2 border-solid border-red-700 rounded-md'
                    : ''
                "
              ></a-select>
              <div
                v-if="errors && errors?.department_id"
                :class="{
                  'text-red-500': errors && errors?.department_id,
                }"
                class="w-100"
              >
                {{ errors?.department_id[0] }}
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-12 col-sm-3 text-start text-sm-end"></div>

            <div class="col-12 col-sm-5">
              <a-checkbox v-model:checked="change_password">
                Đổi Mật khẩu
              </a-checkbox>
            </div>
          </div>

          <div class="row mb-3" v-if="change_password == true">
            <div class="col-12 col-sm-3 text-start text-sm-end">
              <label>
                <span class="text-danger me-1">*</span>
                <span :class="errors && errors?.password ? 'text-red-500' : ''"
                  >Mật khẩu:</span
                >
              </label>
            </div>

            <div class="col-12 col-sm-5">
              <a-input-password
                placeholder="Mật khẩu"
                allow-clear
                v-model:value="password"
                :class="
                  errors && errors?.password
                    ? 'border-2 border-solid border-red-700 rounded-md'
                    : ''
                "
              />
              <div
                v-if="errors && errors?.password"
                :class="{
                  'text-red-500': errors && errors?.password,
                }"
                class="w-100"
              >
                {{ errors?.password[0] }}
              </div>
            </div>
          </div>

          <div class="row mb-3" v-if="change_password == true">
            <div class="col-12 col-sm-3 text-start text-sm-end">
              <label>
                <span class="text-danger me-1">*</span>
                <span :class="errors && errors?.password ? 'text-red-500' : ''"
                  >Xác nhận mật khẩu:</span
                >
              </label>
            </div>

            <div class="col-12 col-sm-5">
              <a-input-password
                placeholder="Xác nhận mật khẩu"
                allow-clear
                v-model:value="password_confirmation"
                :class="
                  errors && errors?.password
                    ? 'border-2 border-solid border-red-700 rounded-md'
                    : ''
                "
              />
              <div
                v-if="errors && errors?.password"
                :class="{
                  'text-red-500': errors && errors?.password,
                }"
                class="w-100"
              >
                {{ errors?.password[0] }}
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-12 col-sm-3 text-start text-sm-end">
                <label>
                  <span>Lần Đăng nhập gần đây:</span>
                </label>
              </div>

              <div class="col-12 col-sm-5">
                <span>
                  {{ login_at ? login_at : "Chưa có lần đăng nhập" }}
                </span>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-12 col-sm-3 text-start text-sm-end">
                <label>
                  <span>Lần đổi Mật khẩu gần đây:</span>
                </label>
              </div>

              <div class="col-12 col-sm-5">
                <span>
                  {{
                    change_password_at
                      ? change_password_at
                      : "Chưa có lần đổi mật khẩu"
                  }}
                </span>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12 d-grid d-sm-flex justify-content-sm-end mx-auto">
            <a-button class="me-0 me-sm-2 mb-3 mb-sm-0">
              <router-link :to="{ name: 'admin-users' }">
                <span>Hủy</span>
              </router-link>
            </a-button>

            <a-button type="primary" html-type="submit">
              <span>Sửa</span>
            </a-button>
          </div>
        </div>
      </div>
    </a-card>
    <a-modal
      v-model:open="open"
      title="Xóa tài khoản"
      @ok="handleOk"
      centered
      :confirm-loading="loading"
    >
      <p>
        Bạn có chắc chắn muốn xóa tài khoản này ? Sau khi xóa tài khoản sẽ không
        thể khôi phục lại !
      </p>
    </a-modal>
  </form>
</template>
