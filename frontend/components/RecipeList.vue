<template>
  <ul class="recipe-list flex flex-col gap-2">
    <li 
      v-for="recipe in recipes" 
      :key="recipe.id" 
      class="p-4 border rounded-lg shadow-md hover:bg-gray-100 cursor-pointer"
      @click="$emit('selectRecipe', recipe)"
    >
      <h2 class="text-xl font-semibold">{{ recipe.name }}</h2>
      <p class="text-gray-600 italic">{{ recipe.description }}</p>
    </li>
  </ul>
</template>

<script setup>
defineProps(["recipes"]);
defineEmits(["selectRecipe"]);
</script>
