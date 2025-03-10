<template>
  <div class="pagination">
    <button :disabled="!prevPageUrl" @click="$emit('paginate', prevPageUrl)">Previous</button>
    <span>Page {{ currentPage }} of {{ totalPages }}</span>
    <button :disabled="!nextPageUrl" @click="$emit('paginate', nextPageUrl)">Next</button>
  </div>
</template>

<script setup>
defineProps(["prevPageUrl", "nextPageUrl", "currentPage", "totalPages"]);
</script>

<style scoped>
.pagination {
  @apply flex justify-between items-center mt-4;
}
button {
  @apply px-4 py-2 border rounded disabled:opacity-50;
}
</style>
