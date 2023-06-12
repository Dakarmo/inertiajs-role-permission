<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";
import Table from "@/Components/Table.vue";
import TableRow from "@/Components/TableRow.vue";
import TableHeaderCell from "@/Components/TableHeaderCell.vue";
import TableDataCell from "@/Components/TableDataCell.vue";
import Modal from "@/Components/Modal.vue";
import { ref, watch, defineProps, normalizeClass } from "vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import axios from "axios";
import Pagination from "@/Components/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";

// defineProps(["users"]);

const term = ref("");
const PerPage = ref(10);

const form = useForm({
  term: "",

});

// const term =ref('');

// watch(term, (value) => {
//   Inertia.get(route("users.index"), { term: value });
// });
const showConfirmDeleteUserModal = ref(false);

const confirmDeleteUser = () => {
  showConfirmDeleteUserModal.value = true;
};
const closeModal = () => {
  showConfirmDeleteUserModal.value = false;
};

const deleteUser = (id) => {
  form.delete(route("users.destroy", id), {
    onSuccess: () => closeModal(),
  });
};

/*   sahid*/

const props = defineProps({
  users: Array,
});

console.log(props.users);
let data = ref(props.users);

let name = ref("");

let store = () => {
  axios
    .post("/usersSearch", {
      name: name.value,      
    })
    .then((response) => {
      data.value = response.data.users;
    });

    // console.log(response.data.users);
};

// const searchUser = () => {
//     if(this.q.length > 3) {
//         axios.post(route('users.index') , {term: this.term} )
//         .then(response => this.users = response.data)
//         .catch(error => console.log(error));
//     }else {
//         axios.get('http://127.0.0.1:5000/users/')
//         .then(response => this.users = response.data)
//         .catch(error => console.log(error));
//     }
// }

// const searchUser = () => {
//       this.$inertiget(route('users.index'), { q: this.searchQuery })
//         .then(response => {
//           this.users = response.data.users;
//         })
//         .catch(error => {
//           console.log(error);
//         });
//     alert("ok")
//     }

// const searchUser = () => {
//   Inertia.replace(route("users.index", { term }));
//   console.log(term);
// };

// const searchUser = () => {
//     form.get(route('users.index'), { term });
// }
// const searchUser = () => {
//     console.log('ok')
// }
</script>

<template>
  <Head title="Dashboard" />

  <AdminLayout>
    <div class="mx-w-7xl mx-auto py-4">
      <div class="flex justify-between">
        <h1>Welcome Users Index page</h1>
        <Link
          :href="route('users.create')"
          class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded"
          >New user</Link
        >
      </div>
      <div>
        <!-- <form @submit.prevent="searchUser"> -->
        <input
          @input="store"
          type="search"
          v-model="name"
          placeholder="Search..."
          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-80 pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
        />
        
        <!-- <button class="px-3 py-2 m-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded-lg" type="submit">Search</button> -->
        <!-- </form> -->
      </div>
      <!-- <div class="p-4">
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input type="text"  v-model="search" id="table-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for user">
                </div>
            </div> -->
      <!-- <div class="col-md-8">
                <form @submit.prevent="searchUser" method="get" classe="flex">
                    <input type="texte" placeholder="Rechercher" @input="term" class="form-control no-border-input" name="search"/>
               
                    <button class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded"
                    type="submit">Rechercher</button>
                </form>
            </div> -->

      <!-- <form method="POST" @submit.prevent="submit">
       
        <input type="search" placeholder="Search here" v-model="search" />
        <button type="submit">Search</button>
      </form> -->

      <div class="mt-6">
        <Table>
          <template #header>
            <TableRow>
              <TableHeaderCell>ID</TableHeaderCell>
              <TableHeaderCell>Name</TableHeaderCell>
              <TableHeaderCell>Email</TableHeaderCell>
              <TableHeaderCell>Action</TableHeaderCell>
            </TableRow>
          </template>
          <template #default>
            <TableRow
              v-for="(user, i) in data.data"
              :key="i"
              class="border-b"
            >
              <TableDataCell>{{ user.id }}</TableDataCell>
              <TableDataCell>{{ user.name }}</TableDataCell>
              <TableDataCell>{{ user.email }}</TableDataCell>
              <TableDataCell>
                <Link
                  :href="route('users.edit', user.id)"
                  class="text-green-400 hover:text-green-600 m-4"
                  >Edite</Link
                >
                <!-- <Link :href="route('users.destroy', user.id)" method="delete" as="button" class="text-red-400 hover:text-red-600">Delete</Link> -->
                <button
                  @click="confirmDeleteUser"
                  class="text-red-400 hover:text-red-600"
                >
                  Delete
                </button>
                <Modal :show="showConfirmDeleteUserModal">
                  <div class="p-6">
                    <h2 class="text-lg font-semibold text-slate-800">
                      Are you sure to delete this user ?
                    </h2>
                  </div>
                  <div class="m-6 flex space-x-4">
                    <DangerButton @click="deleteUser(user.id)"
                      >Delete</DangerButton
                    >
                    <SecondaryButton @click="closeModal"
                      >Cancel</SecondaryButton
                    >
                  </div>
                </Modal>
              </TableDataCell>
            </TableRow>
          </template>
        </Table>
      </div>
      <Pagination :data="users" />
    </div>
  </AdminLayout>
</template>
