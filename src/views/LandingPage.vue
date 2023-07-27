<template>
    <a-col :span="12">
        <h2 class="hero-title">Welcome, {{ authUser.username }}</h2>
        <p class="hero-description">{{ authUser.email }}</p>

        <a-button
            @click="router.push(`/users`)"
            v-if="authUser.is_admin"
            type="primary"
            class="cta-button"
            >View Record
        </a-button>
        <a-button @click="subscribe" v-else type="primary" class="cta-button"
            >{{ isSubscribe == 1 ? "Subscribe" : "Unsubscribe" }}
        </a-button>
    </a-col>
    <a-col :span="12">
        <!-- You can add an image here -->
    </a-col>
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
        const isSubscribe = ref(1);
        const authUser = computed(() => store.getters["Auth/user"]);

        onMounted(async () => {
            try {
                await store.dispatch("Auth/user");
            } catch (e) {
                console.error(e);
            }

            let intervalId = setInterval(() => {
                isSubscribe.value = authUser.value.is_subscribe;
                if (isSubscribe.value) {
                    clearInterval(intervalId);
                }
            }, 1000);
        });
        const subscribe = async () => {
            await store
                .dispatch("Auth/subscribe")
                .then((response) => {
                    console.log(response);
                    swal.fire({
                        title: "Success",
                        text:
                            response.data.is_subscribe == 1
                                ? "Subscribe Successfully!"
                                : "Unsubscribe Successfully!",
                        icon: "success",
                        confirmButtonText: "OK",
                        confirmButtonColor: "#F69A22",
                    });
                    isSubscribe.value = response.data.is_subscribe;
                })
                .catch((error) => {
                    console.log(error);
                });
        };

        return {
            authUser,
            subscribe,
            isSubscribe,
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
