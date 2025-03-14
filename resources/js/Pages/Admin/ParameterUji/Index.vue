<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Parameter Uji
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">

                    <div class="p-4">
                        <button @click="openModal()" class="bg-blue-500 text-white px-4 py-2 rounded my-2">
                            Tambah
                        </button>

                        <div class="overflow-x-auto mt-4">
                            <table class="dark:text-white w-full">
                                <thead>
                                    <tr class="bg-slate-600">
                                        <th class="p-3 border-b border-t-2">No</th>
                                        <th class="p-3 border-b border-t-2">Nama</th>
                                        <th class="p-3 border-b border-t-2">Satuan</th>
                                        <th class="p-3 border-b border-t-2">Kadar Maksimum</th>
                                        <th class="p-3 border-b border-t-2">Metode Uji</th>
                                        <th class="p-3 border-b border-t-2">Created at</th>
                                        <th class="p-3 border-b border-t-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in parameterUjis.data" :key="item.id">
                                        <td class="border-b p-2">{{ item.id }}</td>
                                        <td class="border-b p-2">{{ item.nama }}</td>
                                        <td class="border-b p-2">{{ item.satuan }}</td>
                                        <td class="border-b p-2">{{ item.kadar_maksimum_operator }} {{ item.kadar_maksimum_value }}</td>
                                        <td class="border-b p-2">{{ item.metode_uji }}</td>
                                        <td class="border-b p-2">{{ item.created_at }}</td>
                                        <td class="border-b p-2">
                                            <div class="flex">
                                                <button @click="openModal(item)" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</button>
                                                <button @click="deleteUser(item.id)" class="bg-red-500 text-white px-3 py-1 rounded ml-2">Hapus</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="my-4 mx-4 flex gap-2">
                        <button v-for="link in parameterUjis.links" :key="link.label" @click="fetchData(link.url)"
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
                <div class="flex justify-between">
                    <h2 class="text-lg font-bold mb-2">{{ isEdit ? "Edit User" : "Tambah User" }}</h2>
                    <button @click="closeModal">X</button>
                </div>

                <form @submit.prevent="saveUser">
                    <div class="mb-2">
                        <label class="block">Nama</label>
                        <input v-model="form.nama" ref="inputNama" type="text" class="w-full border px-3 py-2 rounded" required />
                    </div>
                    <div class="mb-2">
                        <label class="block">Satuan</label>
                        <input v-model="form.satuan" ref="inputsatuan" type="text" class="w-full border px-3 py-2 rounded" required />
                    </div>
                    <div class="mb-2">
                        <label class="block">Kadar Maksimum</label>
                        <div class="flex">
                            <input v-model="form.kadar_maksimum_operator" ref="inputkadar_maksimum_operator" type="text" class="w-full border px-3 py-2 rounded-s-md" required />
                            <input v-model="form.kadar_maksimum_value" ref="inputkadar_maksimum_value" type="text" class="w-full border px-3 py-2 rounded-e-md" required />
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="block">Metode Uji</label>
                        <input v-model="form.metode_uji" ref="inputmetode_uji" type="text" class="w-full border px-3 py-2 rounded" required />
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
        parameterUjis: Object,
    },
    data() {
        return {
            showModal: false,
            isEdit: false,
            form: {
                id: null,
                nama: "",
                satuan: "",
                kadar_maksimum_operator: "",
                kadar_maksimum_value: "",
                metode_uji: "",
            },
        };
    },
    methods: {
        openModal(user = null) {
            this.showModal = true;
            if (user) {
                this.isEdit = true;
                this.form = user;
            } else {
                this.isEdit = false;
                this.form = { 
                    id: null, 
                    nama: "",
                    satuan: "",
                    kadar_maksimum_operator: "",
                    kadar_maksimum_value: "",
                    metode_uji: ""
                };
            }

            this.$nextTick(() => {
                this.$refs.inputNama?.focus();
            });
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
                router.put(`/admin/parameteruji/${this.form.id}`, this.form, {
                    onSuccess: () => this.closeModal(),
                });
            } else {
                router.post("/admin/parameteruji", this.form, {
                    onSuccess: () => this.closeModal(),
                });
            }
        },
        deleteUser(id) {
            if (confirm("Apakah Anda yakin ingin menghapus user ini?")) {
                router.delete(`/admin/parameteruji/${id}`);
            }
        },
    }
};


</script>