<template>
  <div class="flex justify-between items-center mt-4">
    <button 
      @click="$emit('paginate', currentPage - 1)" 
      :disabled="!prevPageUrl" 
      :class="{
        'bg-yellow-200 text-gray-800  border-yellow-400': prevPageUrl,
          'bg-gray-100 text-gray-700 hover:bg-yellow-100 hover:text-gray-800 cursor-not-allowed': !prevPageUrl
      }"
      class="px-4 py-2 bg-gray-300 rounded disabled:opacity-50 pagination-back border-b-4"
    >
      Previous
    </button>
    
    <span class="text-gray-700">Page {{ currentPage }} of {{ totalPages }}</span>
    
    <button 
      @click="$emit('paginate', currentPage + 1)" 
      :disabled="!nextPageUrl" 
      :class="{
        'bg-yellow-200 text-gray-800  border-yellow-400': !prevPageUrl,
          'bg-gray-100 text-gray-700 hover:bg-yellow-100 hover:text-gray-800 cursor-not-allowed': prevPageUrl
      }"
      class="px-4 py-2 bg-gray-300 rounded disabled:opacity-50 pagination-next border-b-4"
    >
      Next
    </button>
  </div>
</template>

<script setup>
defineProps(["prevPageUrl", "nextPageUrl", "currentPage", "totalPages"]);
defineEmits(["paginate"]);
</script>
