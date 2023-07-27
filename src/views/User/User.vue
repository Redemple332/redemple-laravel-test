<template>
    <a-row>
        <a-col :span="24">
            <a-card>
                <DataTable
                    title="User List"
                    :items="items.data"
                    :fields="fields"
                    showDeleteReason
                    :pagination="items.pagination"
                    @filter="filterRecord"
                    @search="viewRecord"
                    @destroy="deleteRecord"
                    @create="createRecord"
                    @edit="editRecord"
                    :loading="loading == 'loading'"
                    :showSearchInput="false"
                >
                    <!-- <template v-slot:customAction> Test </template> -->
                </DataTable>
            </a-card>
        </a-col>
    </a-row>
</template>

<script lang="ts">
import router from "@/router";
import { computed, defineComponent, onMounted } from "vue";
import { useStore } from "vuex";
export default defineComponent({
    setup() {
        const store = useStore();
        const fields = computed(() => store.getters["User/fields"]);
        const items = computed(() => store.getters["User/items"]);
        const loading = computed(() => store.getters["User/status"]);

        const index = (payload = { page: 1, limit: 10 }) => {
            store.dispatch("User/index", payload);
        };
        onMounted(() => {
            index();
        });

        const filterRecord = (payload: any) => {
            index(payload);
        };
        const viewRecord = (payload: any) => {
            router.push(`User/abc-memorandum/edit/${payload.id}`);
        };

        const createRecord = () => {
            router.push(`User/abc-memorandum/form`);
        };

        const editRecord = (record: any) => {
            router.push(`User/abc-memorandum/edit/${record.id}`);
        };

        const deleteRecord = (payload: any) => {
            store.dispatch("User/destroy", payload);
        };

        const authUser = computed(() => store.getters["Auth/user"]);

        onMounted(async () => {
            try {
                await store.dispatch("Auth/user");
            } catch (e) {
                console.error(e);
            }

            let intervalId = setInterval(() => {
                const admin = authUser.value.is_admin;
                if (!admin) {
                    clearInterval(intervalId);
                    router.push(`/`);
                }
            }, 1000);
        });

        return {
            fields,
            items,
            loading,
            filterRecord,
            viewRecord,
            createRecord,
            editRecord,
            deleteRecord,
        };
    },
});
</script>
