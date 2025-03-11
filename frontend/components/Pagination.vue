<template>
  <div class="flex justify-between items-center mt-4">
    <button 
      @click="$emit('paginate', currentPage - 1)" 
      :disabled="!prevPageUrl" 
      class="px-4 py-2 bg-gray-300 rounded disabled:opacity-50"
    >
      Previous
    </button>
    
    <span class="text-gray-700">Page {{ currentPage }} of {{ totalPages }}</span>
    
    <button 
      @click="$emit('paginate', currentPage + 1)" 
      :disabled="!nextPageUrl" 
      class="px-4 py-2 bg-gray-300 rounded disabled:opacity-50"
    >
      Next
    </button>
  </div>
</template>

<script setup>
defineProps(["prevPageUrl", "nextPageUrl", "currentPage", "totalPages"]);
defineEmits(["paginate"]);
</script>
