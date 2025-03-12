<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router, usePage } from "@inertiajs/vue3";
import { watch, ref, onMounted } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Sinh viên',
        href: '/points',
    },
];

interface Point {
    id: number;
    point: string;
}

interface User {
    id: number;
    name: string;
    point: number;
    oral_test_scores: Point[],
    quiz_scores: Point[],
    midterm_test_scores: Point[],
    final_test_scores: Point[]
}

interface PaginatedUsers {
    data: User[];
    current_page: number;
    per_page: number;
    last_page: number;
}

const props = defineProps<{
    points: PaginatedUsers;
    class_id: number;
}>();

// Chuyển trang bằng Inertia
const changePage = (page: number) => {
    router.get(route("points.index", { page: page, id: props.class_id, search: searchQuery.value }));
};

const editUser = (point: User) => {
    router.get(route("points.edit", { id: props.class_id, point: point.id }));
};

const deleteUser = (point: User) => {
    if (confirm('Bạn có chắc chắn muốn xóa?')) {
        router.delete(route("points.destroy", { id: props.class_id, point: point.id }));
    }
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

const searchQuery = ref("");
onMounted(() => {
    const params = new URLSearchParams(window.location.search);
    searchQuery.value = params.get('search') || '';
});

const searchUsers = () => {
    router.get(route("points.index", { id: props.class_id, search: searchQuery.value }));
};
</script>

<template>
    <Head title="Sinh viên" />

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
                    @click="searchUsers"
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
                        <th class="border border-gray-300 px-4 py-2">Điểm miệng</th>
                        <th class="border border-gray-300 px-4 py-2">Điểm 15 phút</th>
                        <th class="border border-gray-300 px-4 py-2">Điểm 45 phút</th>
                        <th class="border border-gray-300 px-4 py-2">Điểm học kỳ</th>
                        <th class="border border-gray-300 px-4 py-2">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-100" v-for="(point, index) in points.data" :key="point.id">
                        <td class="border border-gray-300 px-4 py-2">{{ (points.current_page - 1) * points.per_page + index + 1 }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ point.name }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <div class="flex gap-1">
                                <div class="border w-[20px] text-center" v-for="oralTestScore in point.oral_test_scores" :key="oralTestScore.id">{{ oralTestScore.point }}</div>
                            </div>
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            <div class="flex gap-1">
                                <div class="border w-[20px] text-center" v-for="quizScore in point.quiz_scores" :key="quizScore.id">{{ quizScore.point }}</div>
                            </div>
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            <div class="flex gap-1">
                                <div class="border w-[20px] text-center" v-for="midterm_test_score in point.midterm_test_scores" :key="midterm_test_score.id">{{ midterm_test_score.point }}</div>
                            </div>
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            <div class="flex gap-1">
                                <div class="border w-[20px] text-center" v-for="finalTestScore in point.final_test_scores" :key="finalTestScore.id">{{ finalTestScore.point }}</div>
                            </div>
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            <button 
                                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 mr-2"
                                @click="editUser(point)"
                            >
                                Sửa
                            </button>
                            <button 
                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                @click="deleteUser(point)"
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
                    @click="changePage(points.current_page - 1)"
                    :disabled="points.current_page === 1"
                >
                    « Trước
                </button>

                <button
                    v-for="page in points.last_page"
                    :key="page"
                    class="px-3 py-1 rounded"
                    :class="page === points.current_page ? 'bg-blue-500 text-white' : 'bg-gray-200'"
                    @click="changePage(page)"
                >
                    {{ page }}
                </button>

                <button
                    class="px-3 py-1 bg-gray-300 rounded disabled:opacity-50"
                    @click="changePage(points.current_page + 1)"
                    :disabled="points.current_page === points.last_page"
                >
                    Sau »
                </button>
            </div>
        </div>
    </AppLayout>
</template>
