<script lang="ts" setup>
import axios from "axios";
import { useMenu } from "../../../store/use-menu";
import { onMounted, ref, reactive, toRefs, watch } from "vue";
import { useRouter } from "vue-router";
import { message } from "ant-design-vue";

const storeMenu = useMenu();
const router = useRouter();
storeMenu.onSelectedKeys(["admin-users"]);
const user_status = ref([]);
const department = ref([]);
const errors = ref();
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
});
const {
  user_name,
  name,
  email,
  password,
  password_confirmation,
  department_id,
  status_id,
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

// Thêm dữ liệu người dùng vào FormData

const createUser = () => {
  const formData = new FormData();
  for (let key in users) {
    formData.append(key, users[key]);
  }
  formData.append("file", file.value);
  axios
    .post("http://localhost:8080/api/user", formData, {
      headers: {
        "Content-Type": `multipart/form-data; boundary=`,
      },
    })
    .then(function (response) {
      if (response) {
        message.success("Tạo mới thành công");
        router.push("/admin/users");
      }
    })
    .catch(function (error) {
      errors.value = error?.response?.data?.errors;
    });
};
onMounted(() => {
  index();
});
const filterOption = (input: string, option: any) => {
  return option.label.toLowerCase().indexOf(input.toLowerCase()) >= 0;
};
</script>

<template>
  <form @submit.prevent="createUser()">
    <a-card title="Tạo mới Tài khoản" style="width: 100%">
      <div class="row mb-3">
        <div class="col-12 col-sm-4 mb-3">
          <div class="row">
            <div class="col-12 d-flex justify-content-center mb-3">
              <a-avatar shape="square" :size="200">
                <template #icon>
                  <img
                    v-if="!selectedImage"
                    src="../../../assets/default.png"
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

          <div class="row mb-3">
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
            <span>Lưu</span>
          </a-button>
        </div>
      </div>
    </a-card>
  </form>
</template>
