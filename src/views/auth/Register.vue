<template>
    <a-layout class="container">
        <a-row type="flex">
            <a-col
                :xs="{ span: 24, order: 1 }"
                :sm="{ span: 24, order: 2 }"
                :md="{ span: 12, order: 1 }"
                class="left-container"
            >
                <div class="left-box">
                    <div class="logo">
                        <img
                            src="https://avatars.githubusercontent.com/u/112720265?s=48&v=4"
                            alt="logo"
                        />
                    </div>
                    <a-form
                        :model="form"
                        name="normal_login"
                        class="login-form"
                        layout="vertical"
                        @finish="onFinish"
                        @finishFailed="onFinishFailed"
                    >
                        <a-form-item
                            name="username"
                            label="USERNAME"
                            :rules="[
                                {
                                    required: true,
                                    message: 'Please input your username!',
                                },
                            ]"
                        >
                            <a-input
                                v-model:value="form.username"
                                placeholder="Username"
                                size="large"
                            >
                                <template #prefix>
                                    <UserOutlined class="site-form-item-icon" />
                                </template>
                            </a-input>
                        </a-form-item>
                        <a-form-item
                            name="email"
                            label="EMAIL"
                            :rules="[
                                {
                                    required: true,
                                    message: 'Please input your email!',
                                },
                            ]"
                        >
                            <a-input
                                v-model:value="form.email"
                                placeholder="Email"
                                size="large"
                            >
                                <template #prefix>
                                    <UserOutlined class="site-form-item-icon" />
                                </template>
                            </a-input>
                        </a-form-item>
                        <a-form-item
                            name="phone"
                            label="PHONE NUMBER"
                            :rules="[
                                {
                                    required: true,
                                    message: 'Please input your phone number!',
                                },
                            ]"
                        >
                            <a-input
                                v-model:value="form.phone"
                                placeholder="phone"
                                size="large"
                            >
                                <template #prefix>
                                    <UserOutlined class="site-form-item-icon" />
                                </template>
                            </a-input>
                        </a-form-item>
                        <a-form-item
                            name="password"
                            label="PASSWORD"
                            :rules="[
                                {
                                    required: true,
                                    message: 'Please input your password!',
                                },
                            ]"
                            style="margin-bottom: 5px"
                        >
                            <a-input-password
                                v-model:value="form.password"
                                placeholder="Password"
                                size="large"
                            >
                                <template #prefix>
                                    <LockOutlined class="site-form-item-icon" />
                                </template>
                            </a-input-password>
                        </a-form-item>
                        <br />
                        <a-form-item
                            name="password_confirmation"
                            label="CONFIRM PASSWORD"
                            :rules="[
                                {
                                    required: true,
                                    message:
                                        'Please input your confirm password!',
                                },
                            ]"
                            style="margin-bottom: 5px"
                        >
                            <a-input-password
                                v-model:value="form.password_confirmation"
                                placeholder="Confirm Password"
                                size="large"
                            >
                                <template #prefix>
                                    <LockOutlined class="site-form-item-icon" />
                                </template>
                            </a-input-password>
                        </a-form-item>
                        <a-form-item>
                            <a class="login" @click="router.push(`/login`)">
                                login Now!</a
                            >
                        </a-form-item>

                        <a-form-item>
                            <a-button
                                :disabled="disabled"
                                type="primary"
                                html-type="submit"
                                class="login-form-button"
                                block
                                shape="round"
                            >
                                REGISTER
                            </a-button>
                        </a-form-item>
                    </a-form>
                </div>
            </a-col>
            <a-col
                :xs="{ span: 24, order: 1 }"
                :sm="{ span: 24, order: 1 }"
                :md="12"
                class="right-container"
            >
                <div class="right-box">
                    <a-typography-title :level="3" class="right-text"
                        >Welcome to User Register</a-typography-title
                    >
                </div>
            </a-col>
        </a-row>
    </a-layout>
</template>

<script lang="ts">
import { defineComponent, reactive, computed, ref } from "vue";
import { UserOutlined, LockOutlined } from "@ant-design/icons-vue";
import Axios from "../../axios";
import { useRouter } from "vue-router";
import { ValidateErrorEntity } from "ant-design-vue/lib/form/interface";
import router from "@/router";
import store from "@/store";

interface Form {
    phone: string;
    username: string;
    email: string;
    password: string;
    password_confirmation: string;
}
export default defineComponent({
    components: {
        UserOutlined,
        LockOutlined,
    },
    setup() {
        const router = useRouter();
        const api = "http://127.0.0.1:8000/api";
        const saving = ref(false);

        const form = reactive<Form>({
            username: "",
            phone: "",
            email: "",
            password: "",
            password_confirmation: "",
        });
        const onFinish = async (values: any) => {
            saving.value = true;

            // / console.log("Success:", values);
            await store
                .dispatch(`User/store`, form)
                .then((res) => {
                    saving.value = false;
                    router.push("/login");
                })
                .catch((err) => {
                    saving.value = false;
                    console.log(err.response.data.errors);
                });
        };

        const onFinishFailed = (errors: ValidateErrorEntity<Form>) => {
            alert("failed");
            //console.log("Failed:", errorInfo);
        };
        const disabled = computed(() => {
            return !(
                form.email &&
                form.password &&
                form.password_confirmation &&
                form.phone &&
                form.username
            );
        });
        return {
            form,
            onFinish,
            onFinishFailed,
            disabled,
            router,
        };
    },
});
</script>

<style scoped>
.container {
    width: 100%;
    height: 100%;
    background-color: #fff;
}

.right-container {
    min-height: 50vh;
    display: flex;
    justify-content: center;
    flex-direction: column;
    background-image: url("https://a.cdn-hotels.com/gdcs/production87/d1048/4ed1a1e8-afa7-4640-b8ca-d1d6ccbb54c1.jpg");
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    background-color: #40a8c5;
    padding: 1rem;
}

.right-container:after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    /* background: linear-gradient(to bottom, transparent 25%, rgba(0, 0, 0, 0.411) 100%); */
    /* background: rgb(240, 71, 35);
    background: linear-gradient(
      180deg,
      rgba(240, 71, 35, 0.0.7) 0%,
      rgba(246, 154, 34, 0.8) 35%,
      rgba(250, 206, 33, 0.6) 100%
    ); */
    background: rgb(0, 171, 160);
    background: linear-gradient(
        180deg,
        rgba(0, 111, 171, 0.7) 0%,
        rgba(0, 211, 112, 0.8) 35%,
        rgba(76, 234, 224, 0.6) 100%
    );
}
.right-box {
    z-index: 1;
    padding: 2rem;
}
.right-text {
    color: #fff;
}

.right-text:first-child {
    font-weight: 500;
}

.right-text:last-child {
    margin-top: 0.75em;
}

.left-container {
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.left-box {
    width: 60%;
}

.login {
    display: flex;
    justify-content: flex-end;
}

button {
    height: 36px;
}

.logo {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 15px auto 30px;
}
.logo img {
    width: 80px;
}
</style>
