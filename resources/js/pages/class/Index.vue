<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router, usePage } from "@inertiajs/vue3";
import { watch, ref, onMounted } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Lớp',
        href: '/classes',
    },
];

interface Student {
    id: number;
    name: string;
}

interface PaginatedClasses {
    data: Student[];
    current_page: number;
    per_page: number;
    last_page: number;
}

defineProps<{
    classes: PaginatedClasses;
}>();

// Chuyển trang bằng Inertia
const changePage = (page: number) => {
    router.get(route("classes.index", { page: page, search: searchQuery.value }));
};

const editStudent = (id: number) => {
    router.get(route("classes.edit", { id: id }));
};

const deleteStudent = (id: number) => {
    if (confirm('Bạn có chắc chắn muốn xóa?')) {
        router.delete(route("classes.destroy", { id: id }));
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
watch(() => page.props.flash.alert_error, (message) => {
    if (message) {
        alert(message); // Hoặc thay bằng thư viện như Toastr, SweetAlert
        page.props.flash.alert_error = null;
    }
});

const searchQuery = ref("");
onMounted(() => {
    const params = new URLSearchParams(window.location.search);
    searchQuery.value = params.get('search') || '';
});

const searchStudents = () => {
    router.get(route("classes.index", { search: searchQuery.value }));
};
</script>

<template>
    <Head title="Lớp" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="flex items-center space-x-2">
                <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Nhập tên lớp..."
                    class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                />
                <button
                    @click="searchStudents"
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition"
                >
                    Tìm kiếm
                </button>
                <a
                    class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition"
                    :href="route('classes.create')"
                >
                    Thêm
                </a>
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
                    <tr class="hover:bg-gray-100" v-for="(item, index) in classes.data" :key="item.id">
                        <td class="border border-gray-300 px-4 py-2">{{ (classes.current_page - 1) * classes.per_page + index + 1 }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ item.name }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <a
                                class="inline-flex items-center bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 mr-2 h-8"
                                :href="route('students.index', { id: item.id })"
                            >
                                Xem sinh viên
                            </a>
                            <button 
                                class="inline-flex items-center bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 mr-2 h-8"
                                @click="editStudent(item.id)"
                            >
                                Sửa
                            </button>
                            <button 
                                class="inline-flex items-center bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 h-8"
                                @click="deleteStudent(item.id)"
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
                    @click="changePage(classes.current_page - 1)"
                    :disabled="classes.current_page === 1"
                >
                    « Trước
                </button>

                <button
                    v-for="page in classes.last_page"
                    :key="page"
                    class="px-3 py-1 rounded"
                    :class="page === classes.current_page ? 'bg-blue-500 text-white' : 'bg-gray-200'"
                    @click="changePage(page)"
                >
                    {{ page }}
                </button>

                <button
                    class="px-3 py-1 bg-gray-300 rounded disabled:opacity-50"
                    @click="changePage(classes.current_page + 1)"
                    :disabled="classes.current_page === classes.last_page"
                >
                    Sau »
                </button>
            </div>
        </div>
    </AppLayout>
</template>
