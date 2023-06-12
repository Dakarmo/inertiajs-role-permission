<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
  roles: Array,
  permissions: Array,
  errors: Object,
  failures:Array, 
  numErrors: Number,
});


const form = useForm({
  superviseur: "",
  file: null,
  login: "",
  prenom: "",
  nom: "",
  matricule: "",
  genre: "",
  campagne: "",
  chef_plateau: "",
  email: "",
  pays: "",
  roles: [],
  permissions: [],
  numErrors:''
});


</script>

<template>
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
        <h1 class="text-2xl p-4">Add new Users</h1>
        <InputError :message="form.errors.file" />
        <div
          class="mt-11 bg-white overflow-hidden shadow-sm sm:rounded-lg px-4 py-4"
        >
          <h2 class="font-semibold text-x">
            Importation fichier (Excel, .csv)
          </h2>

          <p>
            Sélectionnez un fichier Excel/csv pour importer les données dans la
            table "user".
          </p>
          <form
            @submit.prevent="form.post(route('file-import'))"
            enctype="multipart/form-data"
          >
            <div class="mx-4 my-4 flex items-center">
              <TextInput
                id="input"
                type="file"
                name="file"
                required
                @input="form.file = $event.target.files[0]"
                class="relative m-0 block max-w-sm flex-auto rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary-color focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary cursor-pointer"
              />
              <PrimaryButton type="submit" class="ml-6">
                Importer
              </PrimaryButton>
            </div>
          </form>
        </div>
        <!-- <div >
          <ul v-if="errors">
            <li v-for="error in errors" :key="error.id">
              <p>{{ error }}</p>
            </li>
          </ul>
        </div>

        <p>{{ $page.props.failures }}</p> -->
      

        
      </div>
    </div>
   
    <div v-if="numErrors">
      {{ numErrors }} Eléments n'ont pas été importé <button id="togg" type="button">Voir</button>
    
    </div>
    <div v-if="failures" class="md:px-32 py-8 w-full" id="showErrors">
        <div class="shadow overflow-hidden rounded border-b border-gray-200">
            <table class="min-w-full ">
                <thead >
                    <tr>
                        <th class="sticky top-0 px-6 py-3 text-red-900 bg-red-300" >ligne</th>
                        <th class="sticky top-0 px-6 py-3 text-red-900 bg-red-300" >type</th>
                        <th class="sticky top-0 px-6 py-3 text-red-900 bg-red-300" >Erreur</th>
                        <th class="sticky top-0 px-6 py-3 text-red-900 bg-red-300" >Valeur</th>
                    </tr>
                </thead>
                <tbody class="bg-red-100">
                    <tr v-for="failure in failures" :key="failure.index" >
                        <td class="px-6 py-4 text-center">{{ failure['row'] }}</td>
                        <td class="px-6 py-4 text-center">{{ failure['attribute'] }}</td>
                        <td class="px-6 py-4 text-center">{{ failure['error'] }}</td>
                        <td class="px-6 py-4 text-center">{{ failure['value'] }}</td>
                    </tr>
                </tbody>
                
            </table>
        

        </div>
    </div>
  </AdminLayout>
</template>
<style src="vue-multiselect/dist/vue-multiselect.css"></style>



