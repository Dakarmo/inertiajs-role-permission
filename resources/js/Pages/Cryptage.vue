<template>
  <h1> Cryptage</h1>

  <p>{{ texte }}</p>
  <p>{{ decry }}</p>
</template>

<script setup>
const props = defineProps({
  texte: String,
  decry: String,
});
</script>

<style>

</style>