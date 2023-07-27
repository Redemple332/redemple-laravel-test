<template>
    <a-typography-title v-if="title" :level="3" class="title_3">{{
        title
    }}</a-typography-title>

    <a-row justify="space-between" style="margin-bottom: 1.5em">
        <a-space>
            <a-input-search
                placeholder="Search..."
                style="width: 220px"
                v-model:value="form.search"
                @input="
                    debounce(() => {
                        form.search = $event.target.value;
                    })
                "
                v-if="showSearchInput"
            />
        </a-space>
    </a-row>

    <a-table
        :columns="fields"
        :data-source="items"
        :pagination="false"
        :loading="loading"
        style="overflow-x: auto"
    >
        <!-- Action Button -->
        <template v-slot:action="{ record }">
            <span class="btn-spacing">
                <a-button
                    type="primary"
                    @click="$emit('edit', record)"
                    v-if="showEditButton"
                >
                    <template #icon>
                        <FormOutlined />
                    </template>
                    Edit
                </a-button>
                <a-button
                    type="primary"
                    danger
                    @click="onDestroy(record)"
                    v-if="showDeleteButton"
                    :disabled="record.is_admin"
                >
                    <template #icon>
                        <DeleteOutlined />
                    </template>
                    Delete
                </a-button>
                <slot name="customAction"></slot>
            </span>
        </template>
        <template v-slot:is_subscribe="{ record }">
            {{ record.is_subscribe == 1 ? "Yes" : "No" }}
        </template>
    </a-table>

    <!-- Pagination  -->
    <a-row style="margin: 15px 15px" v-if="items.length && showFooter">
        <a-col
            class="search"
            style="display: flex; justify-content: space-between"
            span="24"
        >
            <div>
                <span v-if="pagination"
                    >Showing {{ pagination?.from }} to {{ pagination?.to }} of
                    {{ pagination?.total }} entries</span
                >
            </div>
            <div>
                <a-pagination
                    size="medium"
                    :total="pagination?.total"
                    show-size-changer
                    show-quick-jumper
                    @change="onChange"
                    @showSizeChange="onShowLimit"
                    :current="form.page"
                />
            </div>
        </a-col>
    </a-row>
</template>

<script lang="ts">
import Swal from "sweetalert2";
import { defineComponent, reactive, ref, toRefs, watch } from "vue";

export default defineComponent({
    props: {
        items: {
            type: Array,
            default: () => [],
        },
        fields: {
            type: Array,
            default: () => [],
        },
        showFooter: {
            type: Boolean,
            default: true,
        },
        title: {
            type: String,
            default: "",
        },
        showViewButton: {
            type: Boolean,
            default: false,
        },
        addText: {
            type: String,
            default: "Create",
        },
        showCreateButton: {
            type: Boolean,
            default: true,
        },
        showDeleteButton: {
            type: Boolean,
            default: true,
        },
        showDeleteReason: {
            type: Boolean,
            default: false,
        },
        showEditButton: {
            type: Boolean,
            default: true,
        },
        showRestoreButton: {
            type: Boolean,
            default: false,
        },
        showSearchInput: {
            type: Boolean,
            default: true,
        },
        pagination: {
            type: Object,
        },
        loading: {
            type: Boolean,
            default: false,
        },
        createText: {
            type: String,
            default: "Create ",
        },
    },
    emits: ["view", "edit", "destroy", "create", "search", "filter"],
    setup(props, { emit }) {
        const form = reactive({
            page: 1,
            limit: 10,
            search: "",
        });

        const filter = () => {
            emit("filter", form);
        };

        const onChange = (payload: any) => {
            const { page } = toRefs(form);
            page.value = payload;
            filter();
        };

        const onShowLimit = (current: any, pageSize: any) => {
            const { limit } = toRefs(form);
            const { page } = toRefs(form);
            page.value = 1;
            limit.value = pageSize;
            filter();
        };

        function createDebounce() {
            console.log(form);
            let timeout = 0;
            return function (fnc: any, delayMs: any) {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    const { page } = toRefs(form);
                    page.value = 1;

                    emit("filter", form);
                }, delayMs || 500);
            };
        }

        const onDestroy = (payload: any) => {
            Swal.fire({
                title: "Are you sure?",
                text: "This action is irreversible.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#6C757E",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    emit("destroy", payload);
                }
            });
        };

        return {
            filter,
            onChange,
            debounce: createDebounce(),
            form,
            onDestroy,
            onShowLimit,
        };
    },
});
</script>
<style>
.btn-spacing {
    display: flex;
    gap: 5px;
}
</style>
