<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import Table from "@/Components/Table.vue"
import TableRow from "@/Components/TableRow.vue"
import TableHeaderCell from "@/Components/TableHeaderCell.vue"
import TableDataCell from "@/Components/TableDataCell.vue"
import { onMounted, watch} from "vue";

const props = defineProps({
  post: {
    type: Object,
    required: true,
  },

});

const form = useForm({
  title: props.post.title,
  contenu: props.post.contenu,
});

</script>

<template>
  <Head title="Update Post" />

  <AdminLayout>
    <div class="mx-w-7xl mx-auto py-4">
      <div class="flex justify-between">
        <Link
          :href="route('posts.index')"
          class="px-3 py-2 text-white font-semibold bg-indigo-500 hover:bg-indigo-700 rounded"
          >Back</Link
        >
      </div>
      <div class="mt-6 max-w-6xl mx-auto bg-slate-100 shadow-lg rounded-lg p-8">
        <h1 class="text-2xl font-semibold text-indigo-700">Update post</h1>
        <form @submit.prevent="form.put(route('posts.update', post.id))">
          <div  class="mt-4">
            <InputLabel for="title" value="title" />

            <TextInput
              id="title"
              type="text"
              class="mt-1 block w-full"
              v-model="form.title"
              autofocus
              autocomplete="title"
            />

            <InputError class="mt-2" :message="form.errors.title" />
          </div>
          <div class="mt-4">
                <InputLabel for="contenu" value="contenu" />

                <textarea
                    id="contenu"
                    type="textarea"
                    class="mt-1 block w-full"
                    v-model="form.contenu"
                    autofocus
                    autocomplete="contenu"
                ></textarea>

                <InputError class="mt-2" :message="form.errors.contenu" />
            </div>
          <div class="flex items-center mt-4">
            <PrimaryButton
              class="ml-4"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Update
            </PrimaryButton>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>
