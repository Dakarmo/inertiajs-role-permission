<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import Table from "@/Components/Table.vue"
import TableRow from "@/Components/TableRow.vue"
import TableHeaderCell from "@/Components/TableHeaderCell.vue"
import TableDataCell from "@/Components/TableDataCell.vue"
import Modal from "@/Components/Modal.vue";
import { ref } from 'vue';
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

defineProps(['permissions'])

const form = useForm({});

const showConfirmDeletePermissionModal = ref(false);

const confirmDeletePermission = () => {
    showConfirmDeletePermissionModal.value = true;
}
const closeModal = () => {
    showConfirmDeletePermissionModal.value = false;
}

const deletePermission = (id) => {
    form.delete(route('permissions.destroy', id), {
        onSuccess: () => closeModal()
    });
}

</script>

<template>
    <Head title="Dashboard" />

    <AdminLayout>
        <div class="mx-w-7xl mx-auto py-4">
            <div class="flex justify-between">
                <h1>Welcome Permissions Index page</h1>
                <Link :href="route('permissions.create')" class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded">New Permission</Link>
            </div>
        </div>
        <div class="mt-6">
           
            <div class="mt-6">
                <Table>
                    <template #header>
                        <TableRow>
                            <TableHeaderCell>ID</TableHeaderCell>
                            <TableHeaderCell>Name</TableHeaderCell>
                            <TableHeaderCell>Action</TableHeaderCell>
                        </TableRow>
                    </template>
                    <template #default>
                        <TableRow v-for="(permission, i) in permissions" :key="permission.id" class="border-b">
                            <TableDataCell>{{ ++i }}</TableDataCell>
                            <TableDataCell>{{ permission.name }}</TableDataCell>
                            <TableDataCell>
                                <Link :href="route('permissions.edit', permission.id)" class="text-green-400 hover:text-green-600 m-4">Edite</Link>
                                <!-- <Link :href="route('permissions.destroy', permission.id)" method="delete" as="button" class="text-red-400 hover:text-red-600">Delete</Link> -->
                                <button @click="confirmDeletePermission" class="text-red-400 hover:text-red-600">
                                    Delete
                                </button>
                                <Modal :show="showConfirmDeletePermissionModal">
                                    <div class="p-6">
                                        <h2 class="text-lg font-semibold text-slate-800">Are you sure to delete this user ?</h2>
                                    </div>
                                    <div class="m-6 flex space-x-4">
                                        <DangerButton @click="deletePermission(permission.id)">Delete</DangerButton>
                                        <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                                    </div>

                                </Modal>
                            </TableDataCell>
                        </TableRow>
                    </template>
                </Table>
            </div>
        </div>
    </AdminLayout>
</template>

