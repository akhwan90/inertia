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

                    <div class="p-4">
                        <button @click="openModal()" class="bg-blue-500 text-white px-4 py-2 rounded my-2">
                            Tambah User
                        </button>

                        <div class="overflow-x-auto mt-4">
                            <table class="dark:text-white w-full">
                                <thead>
                                    <tr class="bg-slate-600">
                                        <th class="p-3 border-b-2 border-t-2">No</th>
                                        <th class="p-3 border-b-2 border-t-2">Email</th>
                                        <th class="p-3 border-b-2 border-t-2">Nama</th>
                                        <th class="p-3 border-b-2 border-t-2">Level</th>
                                        <th class="p-3 border-b-2 border-t-2">Provider</th>
                                        <th class="p-3 border-b-2 border-t-2">Provider ID</th>
                                        <th class="p-3 border-b-2 border-t-2">Created at</th>
                                        <th class="p-3 border-b-2 border-t-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="user in users.data" :key="user.id">
                                        <td class="border-b-2 p-2">{{ user.id }}</td>
                                        <td class="border-b-2 p-2">{{ user.name }}</td>
                                        <td class="border-b-2 p-2">{{ user.email }}</td>
                                        <td class="border-b-2 p-2">{{ user.level }}</td>
                                        <td class="border-b-2 p-2">{{ user.provider }}</td>
                                        <td class="border-b-2 p-2">{{ user.provider_id }}</td>
                                        <td class="border-b-2 p-2">{{ user.created_at }}</td>
                                        <td class="border-b-2 p-2">
                                            <div class="flex">
                                                <button @click="openModal(user)" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</button>
                                                <button @click="deleteUser(user.id)" class="bg-red-500 text-white px-3 py-1 rounded ml-2">Hapus</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="my-4 mx-4 flex gap-2">
                        <button v-for="link in users.links" :key="link.label" @click="fetchData(link.url)"
                            :disabled="!link.url" class="px-3 py-1 border rounded-md text-white"
                            :class="{ 'bg-gray-300': link.active, 'cursor-not-allowed': !link.url }"
                            v-html="link.label" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div v-if="showModal" class="fixed inset-4 flex items-center justify-center bg-gray-900 bg-opacity-80">
            <div class="bg-white p-6 rounded shadow-md w-full max-w-sm sm:max-w-lg sm:h-auto md:max-w-xl lg:max-w-2xl xl:max-w-4xl sm:w-full">
                <h2 class="text-lg font-bold mb-2">{{ isEdit ? "Edit User" : "Tambah User" }}</h2>

                <form @submit.prevent="saveUser">
                    <div class="mb-2">
                        <label class="block">Nama</label>
                        <input v-model="form.name" type="text" class="w-full border px-3 py-2 rounded" required />
                    </div>
                    <div class="mb-2">
                        <label class="block">Email</label>
                        <input v-model="form.email" type="email" class="w-full border px-3 py-2 rounded" required />
                    </div>
                    <div class="mb-2">
                        <label class="block">Password</label>
                        <input v-model="form.password" type="password" class="w-full border px-3 py-2 rounded" />
                    </div>
                    <div class="mb-2">
                        <label class="block">Level <small class="text-red-400">(admin, user)</small></label>
                        <input v-model="form.level" type="text" class="w-full border px-3 py-2 rounded" required />
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="closeModal" class="bg-gray-400 px-3 py-1 rounded">Batal</button>
                        <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded">{{ isEdit ? "Simpan" :
                            "Tambah" }}</button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { Inertia } from '@inertiajs/inertia';
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

export default {
    components: {
        AuthenticatedLayout,
        Head
    },
    props: {
        users: Object,
    },
    data() {
        return {
            showModal: false,
            isEdit: false,
            form: {
                id: null,
                name: "",
                email: "",
                password: "",
                level: "",
            },
        };
    },
    methods: {
        openModal(user = null) {
            this.showModal = true;
            if (user) {
                this.isEdit = true;
                this.form = { ...user, password: "" }; // Tidak mengubah password
            } else {
                this.isEdit = false;
                this.form = { id: null, name: "", email: "", password: "" };
            }
        },
        closeModal() {
            this.showModal = false;
        },
        fetchData(url) {
            if (url) {
                router.visit(url); // Memuat halaman baru menggunakan Inertia
            }
        },
        saveUser() {
            if (this.isEdit) {
                router.put(`/admin/user/${this.form.id}`, this.form, {
                    onSuccess: () => this.closeModal(),
                });
            } else {
                router.post("/admin/user", this.form, {
                    onSuccess: () => this.closeModal(),
                });
            }
        },
        deleteUser(id) {
            if (confirm("Apakah Anda yakin ingin menghapus user ini?")) {
                router.delete(`/admin/user/${id}`);
            }
        },
    }
};


</script>