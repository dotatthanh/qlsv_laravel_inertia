<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router, usePage } from "@inertiajs/vue3";
import { watch, ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Student',
        href: '/students',
    },
];

interface Student {
    id: number;
    name: string;
}

interface PaginatedStudents {
    data: Student[];
    current_page: number;
    per_page: number;
    last_page: number;
}

const props = defineProps<{
    students: PaginatedStudents;
    class_id: number;
}>();

// Chuyển trang bằng Inertia
const changePage = (page: number) => {
    router.get(route("students.index", { page: page, id: props.class_id, search: searchQuery.value }));
};

const editStudent = (student: Student) => {
    router.get(route("students.edit", { id: props.class_id, student: student.id }));
};

const deleteStudent = (student: Student) => {
    if (confirm('Bạn có chắc chắn muốn xóa?')) {
        router.delete(route("students.destroy", { id: props.class_id, student: student.id }));
    }
};

const page = usePage();
// Theo dõi flash message để hiển thị thông báo khi có thay đổi
watch(() => page.props.flash.alert_success, (message) => {
    if (message) {
        alert(message); // Hoặc thay bằng thư viện như Toastr, SweetAlert
        page.props.flash.alert_success = null;
    }
});

const searchQuery = ref("");
const searchStudents = () => {
    router.get(route("students.index", { id: props.class_id, search: searchQuery.value }));
};
</script>

<template>
    <Head title="Student" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex items-center space-x-2">
                <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Nhập tên sinh viên..."
                    class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                <button
                    @click="searchStudents"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition"
                >
                    Tìm kiếm
                </button>
            </div>

            <table class="table-auto border-collapse border border-gray-300 w-full text-left">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border border-gray-300 px-4 py-2">STT</th>
                        <th class="border border-gray-300 px-4 py-2">Tên</th>
                        <th class="border border-gray-300 px-4 py-2">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-100" v-for="(student, index) in students.data" :key="student.id">
                        <td class="border border-gray-300 px-4 py-2">{{ (students.current_page - 1) * students.per_page + index + 1 }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ student.name }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <button 
                                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 mr-2"
                                @click="editStudent(student)"
                            >
                                Sửa
                            </button>
                            <button 
                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                @click="deleteStudent(student)"
                            >
                                Xóa
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Phân trang -->
            <div class="flex justify-center space-x-2 mt-4">
                <button
                    class="px-3 py-1 bg-gray-300 rounded disabled:opacity-50"
                    @click="changePage(students.current_page - 1)"
                    :disabled="students.current_page === 1"
                >
                    « Trước
                </button>

                <button
                    v-for="page in students.last_page"
                    :key="page"
                    class="px-3 py-1 rounded"
                    :class="page === students.current_page ? 'bg-blue-500 text-white' : 'bg-gray-200'"
                    @click="changePage(page)"
                >
                    {{ page }}
                </button>

                <button
                    class="px-3 py-1 bg-gray-300 rounded disabled:opacity-50"
                    @click="changePage(students.current_page + 1)"
                    :disabled="students.current_page === students.last_page"
                >
                    Sau »
                </button>
            </div>
        </div>
    </AppLayout>
</template>
