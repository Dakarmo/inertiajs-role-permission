<template>
    <div>
      <h1 v-if="status === 404">Page Not Found</h1>
      <h1 v-else-if="status === 500">Internal Server Error</h1>
      <h1 v-else>Unknown Error</h1>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      status: {
        type: Number,
        required: true,
      },
    },
  };
  </script>