<template>
    <div class="landing-page">
        <a-row class="header">
            <a-col :span="12">
                <h1 class="logo">Welcome, {{ authUser.username }}</h1>
            </a-col>
            <a-col :span="12" class="header-links">
                <a @click="router.push(`/`)" href="#">Home</a>
                <a-button @click="logout" type="primary">Logout</a-button>
            </a-col>
        </a-row>
        <a-row class="hero-section" type="flex" align="middle" justify="center">
            <router-view></router-view>
        </a-row>

        <a-row class="footer">
            <a-col :span="24" class="footer-content">
                <p>© 2023 Redemple. All rights reserved.</p>
            </a-col>
        </a-row>
    </div>
</template>
<script lang="ts">
import { useRouter } from "vue-router";
import { computed, defineComponent, onMounted, ref } from "vue";
import axios from "../axios";
import { useStore } from "vuex";
import swal from "sweetalert2";

export default defineComponent({
    setup() {
        const store = useStore();
        const router = useRouter();

        onMounted(async () => {
            try {
                await store.dispatch("Auth/user");
            } catch (e) {
                console.error(e);
            }
        });
        const authUser = computed(() => store.getters["Auth/user"]);
        const logout = async () => {
            window.localStorage.removeItem("REDEMPLE_TOKEN");
            await axios
                .post("logout")
                .then((response) => {
                    console.log(response);
                })
                .catch((error) => {
                    console.log(error);
                });
            await router.push("/login");
        };

        return {
            authUser,
            logout,
            router,
        };
    },
});
</script>
<style>
/* Add your custom styles here */

.landing-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.header {
    padding: 10px 0;
}

.logo {
    font-size: 24px;
    font-weight: bold;
    color: #1890ff;
    margin: 0;
}

.header-links {
    text-align: right;
}

.header-links a {
    margin-right: 20px;
    color: #000;
}

.hero-section {
    padding: 40px 0;
}

.hero-title {
    font-size: 36px;
    font-weight: bold;
    color: #000;
    margin: 0;
}

.hero-description {
    font-size: 18px;
    color: #555;
    margin-bottom: 20px;
}

.cta-button {
    margin-top: 20px;
}

.footer {
    background-color: #f0f2f5;
    padding: 20px 0;
    margin-top: 40px;
}

.footer-content {
    text-align: center;
    font-size: 14px;
    color: #777;
}
</style>
