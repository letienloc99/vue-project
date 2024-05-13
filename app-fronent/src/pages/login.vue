<script lang="ts" setup>
import { message } from "ant-design-vue";
import axios from "axios";
import { ref } from "vue";
import { useRouter } from "vue-router";

const email = ref<string>("");
const password = ref<string>("");
const router = useRouter();
const loginSubmit = () => {
  axios
    .post("http://localhost:8080/api/auth/login", {
      email: email.value,
      password: password.value,
    })
    .then(function (response) {
      if (response) {
        localStorage.setItem("token", response?.data?.result?.access_token);
        message.success("Đăng nhập thành công");
        router.push("/admin/users");
      }
    })
    .catch(function (error) {
      console.log(error);
    });
};
</script>

<template>
  <div className="gradient-background">
    <div className="flex justify-center items-center h-screen">
      <div className="login-container">
        <form @submit.prevent="loginSubmit()">
          <div class="mb-3 w-full flex items-center">
            <div class="text-start w-1/5">
              <label>
                <span class="text-danger me-1">*</span>
                <span>Email:</span>
              </label>
            </div>
            <div class="w-full flex-1">
              <a-input placeholder="Email" allow-clear v-model:value="email" />
            </div>
          </div>
          <div class="mb-3 w-full flex items-center">
            <div class="text-start w-1/5">
              <label>
                <span class="text-danger me-1">*</span>
                <span>Mật khẩu:</span>
              </label>
            </div>

            <div class="flex-1 w-full">
              <a-input-password
                placeholder="Mật khẩu"
                allow-clear
                v-model:value="password"
              />
            </div>
          </div>
          <div class="w-full pt-2">
            <a-button type="primary" html-type="submit" class="w-full">
              <span>Đăng nhập</span>
            </a-button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<style lang="css" scoped>
.gradient-background {
  background-image: url(data:image/jpeg;base64,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);
  min-height: 100vh;
  background-repeat: no-repeat;
  background-position: center;
  background-size: cover;
}

.login-container {
  background-color: #fff;
  border-radius: 6px;
  box-shadow: 6px 12px 60px rgb(0 0 0 / 20%);
  width: 100%;
  max-width: 600px;
  margin: 0 auto;
  padding: 32px;
  transition: all 250ms ease-in-out;
}

@media (max-width: 1024px) {
  .gradient-background {
    background-image: none;
    background-color: #fff;
  }

  .login-container {
    box-shadow: none;
    border-radius: 0;
  }
}
</style>
