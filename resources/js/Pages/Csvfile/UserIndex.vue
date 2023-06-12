<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { usePermission } from '@/Composables/permissions';
import Table from "@/Components/Table.vue"
import TableRow from "@/Components/TableRow.vue"
import TableHeaderCell from "@/Components/TableHeaderCell.vue"
import TableDataCell from "@/Components/TableDataCell.vue"
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { ref } from 'vue';
import Modal from "@/Components/Modal.vue"
import axios from "axios";
import Pagination from "@/Components/Pagination.vue";

// defineProps(['users']);

const props = defineProps({
  users: Array,
});
const form = useForm ({})


/**** Search axios*****/
console.log(props.users);
let data = ref(props.users);

let nom = ref("");

let store = () => {
  axios
    .post("/usersSearch", {
      nom: nom.value,      
    })
    .then((response) => {
      data.value = response.data.users;
    });

    console.log(nom);
};

const showConfirmDeleteUserModal = ref(false)
const { hasPermission } = usePermission();
const { hasRole } = usePermission();

const confirmDeleteUser = () => {
    showConfirmDeleteUserModal.value= true;
}

const closeModal = () => {
    showConfirmDeleteUserModal.value= false;
}

const deleteUser = (id) => {
    form.delete(route('users.destroy', id ), {
        onSuccess: () => closeModal()
    });
    
}
</script>

<template>
    <Head title="User" />
   
    <AdminLayout>
        <div class="mx-w-7xl mx-auto py-4">
            <div class="flex justify-end">
             <template v-if="hasPermission('Create User')">  
                <Link :href="route('usercsv.create')"
                    class="px-3 py-2 border-2 border-primary-color font-semibold bg-white text-primary-color hover:bg-primary-color hover:text-white rounded-xl">
                New user</Link>
            </template>
            </div>
           <div class="p-4">
                <label for="table-search" class="sr-only">Search</label>
                <!-- <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input type="text" @input="store" v-model="name" id="table-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for user">
                </div> -->
                <input
          @input="store"
          type="search"
          v-model="nom"
          placeholder="Search..."
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-80 pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        />
            </div>
            <div class="mt-2">
                <Table>
                    <template #header>
                        <TableRow class=" text-white drop-shadow">
                            <TableHeaderCell class="rounded-tl-2xl">ID</TableHeaderCell>
                            <TableHeaderCell>Superviseur</TableHeaderCell>
                            <TableHeaderCell>Prénom</TableHeaderCell>
                            <TableHeaderCell>Nom</TableHeaderCell>
                            <TableHeaderCell>Login</TableHeaderCell> 
                            <TableHeaderCell>Matricule</TableHeaderCell>
                            <TableHeaderCell>Genre</TableHeaderCell>
                            <TableHeaderCell>Campagne</TableHeaderCell>
                            <TableHeaderCell>Chef Plateau</TableHeaderCell>
                            <TableHeaderCell>Email</TableHeaderCell>
                            <TableHeaderCell>Pays</TableHeaderCell>
                            <TableHeaderCell v-if="hasRole('admin')" class="rounded-tr-2xl">Action</TableHeaderCell>
                        </TableRow>
                    </template>
                    <template #default>
                        <TableRow v-for="(user, i) in data.data" :key="i" class="border-b">
                            <TableDataCell>{{ user.id }}</TableDataCell>
                            <TableDataCell>{{ user.superviseur }}</TableDataCell>
                            <TableDataCell>{{ user.prenom }}</TableDataCell>
                            <TableDataCell>{{ user.nom }}</TableDataCell>
                            <TableDataCell>{{user.login}}</TableDataCell> 
                            <TableDataCell>{{ user.matricule }}</TableDataCell>
                            <TableDataCell>{{ user.genre }}</TableDataCell>
                            <TableDataCell>{{ user.campagne }}</TableDataCell>
                            <TableDataCell>{{ user.chef_plateau }}</TableDataCell>
                            <TableDataCell>{{ user.email }}</TableDataCell>
                            <TableDataCell>{{ user.pays }}</TableDataCell>
                            <TableDataCell class="flex">
                                <template v-if="hasRole('admin')"> 
                                    <Link :href="route('users.edit', user.id)" class="text-green-400 hover:text-green-600 m-4">
                                    <PrimaryButton>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6"
                                            fill="currentColor">
                                            <path
                                                d="M14.06,9L15,9.94L5.92,19H5V18.08L14.06,9M17.66,3C17.41,3 17.15,3.1 16.96,3.29L15.13,5.12L18.88,8.87L20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18.17,3.09 17.92,3 17.66,3M14.06,6.19L3,17.25V21H6.75L17.81,9.94L14.06,6.19Z" />
                                        </svg>
                                    </PrimaryButton>
                                    </Link>
                                    <button @click="confirmDeleteUser"
                                        class="text-red-400 hover:text-red-600">
                                    <DangerButton>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6"
                                            fill="currentColor">
                                            <path
                                                d="M20.37,8.91L19.37,10.64L7.24,3.64L8.24,1.91L11.28,3.66L12.64,3.29L16.97,5.79L17.34,7.16L20.37,8.91M6,19V7H11.07L18,11V19A2,2 0 0,1 16,21H8A2,2 0 0,1 6,19Z" />
                                        </svg>
                                    </DangerButton>
                                    </button>
                                </template>
                                <Modal :show="showConfirmDeleteUserModal" >
                                    <div class="p-6">
                                        <h2 class="text-lg font-semibold text-slate-800"> Êtes-vous sûre de vouloir supprimer cet utilisateur ?</h2>
                                        <div class="mt-6 flex space-x-4">
                                            <DangerButton @click="deleteUser(user.id)">Delete</DangerButton>
                                            <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                                        </div>

                                    </div>
                                </Modal>
                                <!-- <Link :href="route('users.destroy', user.id)" method="delete" as="button"
                                    class="text-red-400 hover:text-red-600">
                                <DangerButton>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6"
                                        fill="currentColor">
                                        <path
                                            d="M20.37,8.91L19.37,10.64L7.24,3.64L8.24,1.91L11.28,3.66L12.64,3.29L16.97,5.79L17.34,7.16L20.37,8.91M6,19V7H11.07L18,11V19A2,2 0 0,1 16,21H8A2,2 0 0,1 6,19Z" />
                                    </svg>
                                </DangerButton>
                                </Link> -->
                            </TableDataCell>
                        </TableRow>
                    </template>
                </Table>
            </div>
            <Pagination :data="users" />
        </div>
    </AdminLayout>
</template>
