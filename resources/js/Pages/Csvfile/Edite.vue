<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import VueMultiselect from "vue-multiselect";
import Table from "@/Components/Table.vue";
import TableRow from "@/Components/TableRow.vue";
import TableHeaderCell from "@/Components/TableHeaderCell.vue";
import TableDataCell from "@/Components/TableDataCell.vue";
import { onMounted, watch } from "vue";
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { ref } from 'vue';
import Modal from "@/Components/Modal.vue"

const props = defineProps({
  user: {
    type: Object,
    required: true,
  },
  roles: Array,
  permissions: Array,
});
const form = useForm({
  nom: props.user.nom,
  prenom: props.user.prenom,
  login: props.user.login,
  matricule: props.user.matricule,
  genre: props.user.genre,
  campagne: props.user.campagne,
  superviseur: props.user.superviseur,
  chef_plateau: props.user.chef_plateau,
  pays: props.user.pays,
  email: props.user.email,
  roles: [],
  permissions: [],
});

const submit = () => {
  form.put(route("users.update", props.user.id));
};

onMounted(() => {
    form.permissions = props.user.permissions;
    form.roles = props.user.roles;
});

watch(
  () => props.user,
  () => {
    form.permissions = props.user.permissions,
    form.roles = props.user.roles
  }
);



const showConfirmRevokeRoleModal = ref(false)

const confirmRevokeRole = () => {
    showConfirmRevokeRoleModal.value= true;
}

const closeModal = () => {
    showConfirmRevokeRoleModal.value= false;
}

const RevokeRole = (id1, id2) => {
    form.delete(route('users.roles.destroy',  [id1, id2]), {
        onSuccess: () => closeModal()
    });
    
}
const RevokePermission = (id1, id2) => {
    form.delete(route('users.permissions.destroy',  [id1, id2]), {
        onSuccess: () => closeModal()
    });
    
}



</script>

<template>
  <Head title="Update user" />

  <AdminLayout>
    <div class="mx-w-7xl mx-auto py-4">
      <div class="flex justify-between">
        <Link
          :href="route('users.index')"
          class="px-3 py-2 font-semibold text-primary-color border-2 border-primary-color hover:text-white hover:bg-primary-color rounded-xl"
          >Back</Link
        >
      </div>
      <div class="mt-6 max-w-6xl mx-auto bg-slate-100 shadow-lg rounded-lg p-8">
        <h1 class="text-2xl p-4">Attribuer Role/Permission</h1>
        <form @submit.prevent="submit">
          <!--<div class="mt-4">
             <InputLabel for="name" value="Name" /> 

            <TextInput
              id="name"
              type="text"
              class="mt-1 block w-full"
              v-model="form.nom"
              required
              autofocus
              autocomplete="name"
            /> -->
            <div class="mt-1 block w-full">
              <p class="px-6">Nom : {{ user.nom }}</p>
              <p class="px-6">Prénom : {{ user.prenom }}</p>
              <p class="px-6">Login : {{ user.login }}</p>
              <p class="px-6">Email : {{ user.email }}</p>
              <p class="px-6">Matricule : {{ user.matricule }}</p>
              <p class="px-6">Genre : {{ user.genre }}</p>
              <p class="px-6">Campagne : {{ user.campagne }}</p>
              <p class="px-6">Superviseur :{{ user.superviseur }}</p>
              <p class="px-6">Chef Plateau : {{ user.chef_plateau }}</p>
              <p class="px-6">Pays : {{ user.pays }}</p>
                            
            </div>

          <div class="mt-4">
            <InputLabel for="roles" value="Roles" />
            <VueMultiselect
              v-model="form.roles"
              :options="roles"
              :multiple="true"
              :close-on-select="true"
              placeholder="Choisir"
              label="name"
              track-by="id"
            />
          </div>

          <div class="mt-4">
            <InputLabel for="permissions" value="Permission" />
            <VueMultiselect
              v-model="form.permissions"
              :options="permissions"
              :multiple="true"
              :close-on-select="true"
              placeholder="Choisir"
              label="name"
              track-by="id"
            />
          </div>

          <div class="flex items-center justify-end mt-4">
            <PrimaryButton
              class="ml-4"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Enrégister
            </PrimaryButton>
          </div>
        </form>
      </div>
      <div class="mt-6 max-w-6xl mx-auto bg-slate-100 shadow-lg rounded-lg p-8">
        <h1 class="text-2xl font-semibold text-primary-color">Roles</h1>        
        <div class="bg-white">
                    <Table>
                        <template #header>
                            <TableRow  class=" text-white drop-shadow">
                                <TableHeaderCell class="rounded-tl-2xl">ID</TableHeaderCell>
                                <TableHeaderCell>Name</TableHeaderCell>
                                <TableHeaderCell class="rounded-tr-2xl">Action</TableHeaderCell>
                            </TableRow>
                        </template>
                        <template #default>
                            <TableRow v-for="(userRole, i) in user.roles" :key="userRole.id" class="border-b">
                                <TableDataCell>{{ ++i }}</TableDataCell>
                                <TableDataCell>{{ userRole.name }}</TableDataCell>
                                <TableDataCell>
                                    <!-- <Link :href="route('users.roles.destroy',  [user.id, userRole.id])" method="delete" as="button" class="text-red-400 hover:text-red-600">Retirer</Link> -->
                                    <button @click="confirmRevokeRole" 
                                    class="text-red-400 hover:text-red-600">
                                <DangerButton>
                                    Retirer
                                </DangerButton>
                                </button> 
                                <Modal :show="showConfirmRevokeRoleModal" >
                                    <div class="p-6">
                                        <h2 class="text-lg font-semibold text-slate-800"> Êtes-vous sûre de vouloir lui retirer le rôle ?</h2>
                                        <div class="mt-6 flex space-x-4">
                                            <DangerButton @click="RevokeRole(user.id, userRole.id)">Delete</DangerButton>
                                            <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                                        </div>

                                    </div>
                                </Modal>
                                  </TableDataCell>
                            </TableRow>
                        </template>
                    </Table>
                </div>
            </div>
      <div class="mt-6 max-w-6xl mx-auto bg-slate-100 shadow-lg rounded-lg p-8">
        <h1 class="text-2xl font-semibold text-primary-color">Permissions</h1>        
        <div class="bg-white">
                    <Table>
                        <template #header>
                            <TableRow class=" text-white drop-shadow">
                                <TableHeaderCell class="rounded-tl-2xl">ID</TableHeaderCell>
                                <TableHeaderCell>Name</TableHeaderCell>
                                <TableHeaderCell class="rounded-tr-2xl">Action</TableHeaderCell>
                            </TableRow>
                        </template>
                        <template #default>
                            <TableRow v-for="(userPermission, i) in user.permissions" :key="userPermission.id" class="border-b">
                                <TableDataCell>{{ ++i }}</TableDataCell>
                                <TableDataCell>{{ userPermission.name }}</TableDataCell>
                                <TableDataCell>
                                    <Link :href="route('users.permissions.destroy',  [user.id, userPermission.id])" method="delete" as="button" class="text-red-400 hover:text-red-600">Supprimer</Link>
                                    <!-- <button @click="confirmRevokeRole" 
                                    class="text-red-400 hover:text-red-600">
                                <Link class="text-red-400 hover:text-red-600">
                                    Retirer
                                </Link>
                                </button> 
                                <Modal :show="showConfirmRevokeRoleModal" >
                                    <div class="p-6">
                                        <h2 class="text-lg font-semibold text-slate-800"> Êtes-vous sûre de vouloir lui retirer la permission ?</h2>
                                        <div class="mt-6 flex space-x-4">
                                            <DangerButton @click="RevokePermission(user.id, userPermission.id)">Delete</DangerButton>
                                            <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                                        </div>

                                    </div>
                                </Modal> -->
                                </TableDataCell>
                            </TableRow>
                        </template>
                    </Table>
                </div>
            </div>
    </div>
  </AdminLayout>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>


