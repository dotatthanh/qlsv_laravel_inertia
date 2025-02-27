<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Lớp',
        href: `/classes`,
    },
    {
        title: 'Tạo lớp',
        href: `/classes/create`,
    },
];

// Form dữ liệu
const form = useForm({
    name: "",
});

// Trạng thái xử lý
const processing = ref(false);

interface Errors {
    name?: string | string[];
}
// Lỗi validation từ server
const errors = ref<Errors>({});

// Xử lý gửi form
const submitForm = () => {
    processing.value = true;

    form.post(route("classes.store"), {
        onError: (err) => {
            errors.value = err;
        },
        onFinish: () => {
            processing.value = false;
        },
    });
};
</script>

<template>
    <Head title="Tạo lớp" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col items-center justify-center">
            <div class="bg-white shadow-lg rounded-2xl p-6 w-full max-w-lg">
                <form @submit.prevent="submitForm" class="space-y-4">
                    <!-- Tên lớp -->
                    <div>
                        <label class="block text-gray-600 font-medium">Tên lớp</label>
                        <input
                            v-model="form.name"
                            type="text"
                            class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-400 focus:border-blue-500"
                            placeholder="Nhập tên lớp"
                        />
                        <p v-if="errors.name" class="text-red-500 text-sm">{{ errors.name }}</p>
                    </div>

                    <!-- Nút Submit -->
                    <button
                        type="submit"
                        class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition font-semibold"
                        :disabled="processing"
                    >
                        {{ processing ? "Đang xử lý..." : "Lưu lại" }}
                    </button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
