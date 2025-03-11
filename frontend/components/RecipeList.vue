<template>
  <ul class="recipe-list flex flex-col gap-2">
    <li 
      v-for="recipe in recipes" 
      :key="recipe.id" 
      class="recipe-list-item p-4 border rounded-lg hover:bg-gray-100 cursor-pointer"
      :class="{ 'border-yellow-400 bg-yellow-50 text-yellow-500' : selectedRecipe?.id === recipe.id }"
      @click="selectRecipe(recipe)"
    >
      <h2 class="text-xl font-semibold">
        <NuxtLink :to="'/recipe/' + recipe.slug">{{ recipe.name }}</NuxtLink>
      </h2>
      <p class="text-gray-600 italic">{{ recipe.description }}</p>
    </li>
  </ul>
</template>

<script setup>
import { ref, nextTick } from "vue";

defineProps(["recipes"]);
const emit = defineEmits(["selectRecipe"]);


const selectedRecipe = ref(null);

const selectRecipe = async (recipe) => {
    selectedRecipe.value = recipe;
    emit("selectRecipe", recipe);

    // Scroll to top of the list when an item is clicked
    await nextTick();
    document.querySelector(".selected-results")?.scrollIntoView({ behavior: "smooth", block: "start" });
    
};
</script>
