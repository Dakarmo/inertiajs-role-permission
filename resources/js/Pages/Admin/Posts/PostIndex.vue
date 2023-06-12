<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Table from "@/Components/Table.vue";
import TableRow from "@/Components/TableRow.vue";
import TableHeaderCell from "@/Components/TableHeaderCell.vue";
import TableDataCell from "@/Components/TableDataCell.vue";
import { Link } from '@inertiajs/vue3';
import Modal from "@/Components/Modal.vue";
import { ref } from 'vue';
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

defineProps(['posts'])

const form = useForm({});

const showConfirmDeletePostModal = ref(false);

const confirmDeletePost = () => {
    showConfirmDeletePostModal.value = true;
}
const closeModal = () => {
    showConfirmDeletePostModal.value = false;
}

const deletePost = (id) => {
    form.delete(route('posts.destroy', id), {
        onSuccess: () => closeModal()
    });
}

</script>

<template>
    <Head title="posts Index" />

    <AdminLayout>

        <div class="mx-w-7xl mx-auto py-4">
            <div class="flex justify-between">
                <h1>Welcome Posts Index page</h1>
                <Link :href="route('posts.create')" class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded">New Post</Link>
            </div>
        <div class="mt-6">
                <Table>
                    <template #header>
                        <TableRow>
                            <TableHeaderCell>ID</TableHeaderCell>
                            <TableHeaderCell>Title</TableHeaderCell>
                            <TableHeaderCell>Content</TableHeaderCell>
                            <TableHeaderCell>Action</TableHeaderCell>
                        </TableRow>
                    </template>
                    <template #default>
                        <TableRow v-for="post in posts" :key="post.id" class="border-b">
                            <TableDataCell>{{ post.id }}</TableDataCell>
                            <TableDataCell>{{ post.title }}</TableDataCell>
                            <TableDataCell>{{ post.contenu }}</TableDataCell>
                            <TableDataCell>
                                <Link :href="route('posts.edit', post.id)" class="text-green-400 hover:text-green-600 m-4">Edite</Link>
                                <!-- <Link :href="route('roles.destroy', role.id)" method="delete" as="button" class="text-red-400 hover:text-red-600">Delete</Link> -->
                                <button @click="confirmDeletePost" class="text-red-400 hover:text-red-600">
                                    Delete
                                </button>
                                <Modal :show="showConfirmDeletePostModal">
                                    <div class="p-6">
                                        <h2 class="text-lg font-semibold text-slate-800">Are you sure to delete this Post ?</h2>
                                    </div>
                                    <div class="m-6 flex space-x-4">
                                        <DangerButton @click="deletePost(post.id)">Delete</DangerButton>
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
