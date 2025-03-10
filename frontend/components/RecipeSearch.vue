<template>
  <div class="search-container">
    <input 
      :value="keyword" 
      @input="$emit('update:keyword', $event.target.value)"
      placeholder="Keyword (name, description, steps, ingredients)..." 
      class="search-input" 
    />
    
    <input 
      :value="ingredient" 
      @input="$emit('update:ingredient', $event.target.value)"
      placeholder="Ingredient..." 
      class="search-input" 
    />
    
    <input 
      :value="authorEmail" 
      @input="$emit('update:authorEmail', $event.target.value)"
      placeholder="Author email..." 
      class="search-input" 
    />
  </div>
</template>

<script setup>
defineProps(["keyword", "ingredient", "authorEmail"]);
</script>

<style scoped>
.search-container {
  @apply w-full mb-4;
}
.search-input {
  @apply w-full p-2 border rounded-md mb-2;
}
</style>
