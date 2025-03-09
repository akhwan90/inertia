<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Data User
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        Daftar User
                    </div>

                    <div class="p-4">
                        <table class="dark:text-white w-full">
                            <thead>
                                <tr class="bg-slate-600">
                                    <th class="p-3 border-b-2 border-t-2">No</th>
                                    <th class="p-3 border-b-2 border-t-2">Email</th>
                                    <th class="p-3 border-b-2 border-t-2">Nama</th>
                                    <th class="p-3 border-b-2 border-t-2">Level</th>
                                    <th class="p-3 border-b-2 border-t-2">Created at</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in users.data" :key="user.id">
                                    <td class="border-b-2 p-2">{{ user.id }}</td>
                                    <td class="border-b-2 p-2">{{ user.name }}</td>
                                    <td class="border-b-2 p-2">{{ user.email }}</td>
                                    <td class="border-b-2 p-2">{{ user.level }}</td>
                                    <td class="border-b-2 p-2">{{ user.created_at }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="my-4 mx-4 flex gap-2">
                        <button v-for="link in users.links" :key="link.label" @click="fetchPage(link.url)"
                            :disabled="!link.url" class="px-3 py-1 border rounded-md text-white"
                            :class="{ 'bg-gray-300': link.active, 'cursor-not-allowed': !link.url }"
                            v-html="link.label" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

export default {
    components: {
        AuthenticatedLayout,
        Head
    },
    props: {
        users: Object,
    },
    method: {
        fetchData(url) {
            if (url) {
                Inertia.visit(url); // Memuat halaman baru menggunakan Inertia
            }
        }
    }
};


</script>