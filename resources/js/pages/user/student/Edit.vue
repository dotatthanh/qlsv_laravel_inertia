<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, router } from "@inertiajs/vue3";
import { ref } from "vue";

interface Student {
    id: number;
    name: string;
    email: string;
}

const props = defineProps<{
    class_id: number;
    student: Student;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Student',
        href: `/classes/${props.class_id}/students`,
    },
    {
        title: 'Edit Student',
        href: `/classes/${props.class_id}/students/${props.class_id}/edit`,
    },
];







// Form dữ liệu
const form = useForm({
    name: props.student.name,
    email: props.student.email,
    password: "",
});

// Trạng thái xử lý
const processing = ref(false);

interface Errors {
    name?: string | string[];
    email?: string | string[];
    password?: string | string[];
}
// Lỗi validation từ server
const errors = ref<Errors>({});

// Xử lý gửi form
const submitForm = () => {
    processing.value = true;

    form.patch(route("students.update", { id: props.class_id, student: props.student.id }), {
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
    <Head title="Student" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <!-- <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            
        </div> -->
        <div class="flex h-full flex-1 flex-col items-center justify-center">
            <div class="bg-white shadow-lg rounded-2xl p-6 w-full max-w-lg">
                <form @submit.prevent="submitForm" class="space-y-4">
                    <!-- Họ và Tên -->
                    <div>
                        <label class="block text-gray-600 font-medium">Họ và Tên</label>
                        <input
                            v-model="form.name"
                            type="text"
                            class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-400 focus:border-blue-500"
                            placeholder="Nhập tên sinh viên"
                        />
                        <p v-if="errors.name" class="text-red-500 text-sm">{{ errors.name }}</p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-gray-600 font-medium">Email</label>
                        <input
                            v-model="form.email"
                            type="email"
                            class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-400 focus:border-blue-500"
                            placeholder="Nhập email"
                        />
                        <p v-if="errors.email" class="text-red-500 text-sm">{{ errors.email }}</p>
                    </div>

                    <!-- Mật khẩu -->
                    <div>
                        <label class="block text-gray-600 font-medium">Mật khẩu</label>
                        <input
                            v-model="form.password"
                            type="password"
                            class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-400 focus:border-blue-500"
                            placeholder="Nhập mật khẩu"
                        />
                        <p v-if="errors.password" class="text-red-500 text-sm">{{ errors.password }}</p>
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
