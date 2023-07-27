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
                        :model="formState"
                        name="normal_login"
                        class="login-form"
                        layout="vertical"
                        @finish="onFinish"
                        @finishFailed="onFinishFailed"
                    >
                        <a-form-item
                            name="email"
                            label="EMAIL / USERNAME"
                            :rules="[
                                {
                                    required: true,
                                    message:
                                        'Please input your email or username!',
                                },
                            ]"
                        >
                            <a-input
                                v-model:value="formState.email"
                                placeholder="Email / Username"
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
                                v-model:value="formState.password"
                                placeholder="Password"
                                size="large"
                            >
                                <template #prefix>
                                    <LockOutlined class="site-form-item-icon" />
                                </template>
                            </a-input-password>
                        </a-form-item>

                        <a-form-item>
                            <a class="login" @click="router.push(`/register`)">
                                Register Now!</a
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
                                LOGIN
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
                        >Welcome to User Login</a-typography-title
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

interface FormState {
    email: string;
    password: string;
}
export default defineComponent({
    components: {
        UserOutlined,
        LockOutlined,
    },
    setup() {
        const router = useRouter();
        const api = "http://127.0.0.1:8000/api";

        const formState = reactive<FormState>({
            email: "",
            password: "",
        });
        const onFinish = async (values: any) => {
            // / console.log("Success:", values);
            const response = await Axios.post(`${api}/login`, values)
                .then((response) => {
                    window.localStorage.setItem(
                        "REDEMPLE_TOKEN",
                        response.data.data.token
                    );
                    window.localStorage.setItem(
                        "ID",
                        response.data.data.user.id
                    );
                    Axios.defaults.headers[
                        "Authorization"
                    ] = `Bearer ${window.localStorage.getItem(
                        "REDEMPLE_TOKEN"
                    )}`;
                    router.push("/");
                    console.log(window.localStorage.getItem("REDEMPLE_TOKEN"));
                })
                .catch((error) => {
                    console.log(error.response); // Log the error response to the console
                });
        };

        const onFinishFailed = (errors: ValidateErrorEntity<FormState>) => {
            alert("failed");
            //console.log("Failed:", errorInfo);
        };
        const disabled = computed(() => {
            return !(formState.email && formState.password);
        });
        return {
            formState,
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
