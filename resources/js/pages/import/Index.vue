<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, usePage } from "@inertiajs/vue3";
import { watch, ref } from "vue";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Nhập điểm',
        href: `/import`,
    },
];

interface Class {
    id: number;
    name: string;
}

defineProps<{
    classes: Class[];
    subjects: Class[];
}>();

// Form dữ liệu
const form = useForm({
    class_id: "",
    subject_id: "",
    file: null,
});

// Trạng thái xử lý
const processing = ref(false);

interface Errors {
    class_id?: string | string[];
    subject_id?: string | string[];
    file?: string | string[];
}
// Lỗi validation từ server
const errors = ref<Errors>({});

// Xử lý gửi form
const submitForm = () => {
    processing.value = true;

    form.post(route("import.store"), {
        onError: (err) => {
            errors.value = err;
        },
        onFinish: () => {
            processing.value = false;
        },
        onSuccess: () => {
            form.reset();
        }
    });
};

const page = usePage();
// Theo dõi flash message để hiển thị thông báo khi có thay đổi
watch(() => (page.props.flash as { alert_success?: string }).alert_success, (message) => {
    if (message) {
        alert(message); // Hoặc dùng Toastr, SweetAlert
        (page.props.flash as { alert_success?: string }).alert_success = undefined;
    }
});
watch(() => (page.props.flash as { alert_error?: string }).alert_error, (message) => {
    if (message) {
        alert(message); // Hoặc dùng Toastr, SweetAlert
        (page.props.flash as { alert_error?: string }).alert_error = undefined;
    }
});
</script>

<template>

    <Head title="Nhập điểm" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col items-center justify-center">
            <div class="bg-white shadow-lg rounded-2xl p-6 w-full max-w-lg">
                <form @submit.prevent="submitForm" class="space-y-4">
                    <!-- Chọn lớp -->
                    <div>
                        <label class="block text-gray-600 font-medium">Tên lớp</label>
                        <select v-model="form.class_id"
                            class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-400 focus:border-blue-500">
                            <option disabled value="">-- Chọn lớp --</option>
                            <option v-for="classItem in classes" :key="classItem.id" :value="classItem.id">
                                {{ classItem.name }}
                            </option>
                        </select>
                        <p v-if="errors.class_id" class="text-red-500 text-sm">{{ errors.class_id }}</p>
                    </div>

                    <!-- Chọn môn học -->
                    <div>
                        <label class="block text-gray-600 font-medium">Tên môn học</label>
                        <select v-model="form.subject_id"
                            class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-400 focus:border-blue-500">
                            <option disabled value="">-- Chọn môn học --</option>
                            <option v-for="subject in subjects" :key="subject.id" :value="subject.id">
                                {{ subject.name }}
                            </option>
                        </select>
                        <p v-if="errors.subject_id" class="text-red-500 text-sm">{{ errors.subject_id }}</p>
                    </div>

                    <!-- Upload file -->
                    <div>
                        <label class="block text-gray-600 font-medium">Tệp excel</label>
                        <input type="file" @change="e => form.file = e.target.files[0]"
                            class="w-full mt-1 border border-gray-300 rounded-lg px-4 py-2 focus:ring focus:ring-blue-400 focus:border-blue-500" />
                        <p v-if="errors.file" class="text-red-500 text-sm">{{ errors.file }}</p>
                    </div>

                    <!-- Nút Submit -->
                    <button type="submit"
                        class="w-full bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition font-semibold"
                        :disabled="processing">
                        {{ processing ? "Đang xử lý..." : "Lưu lại" }}
                    </button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>
