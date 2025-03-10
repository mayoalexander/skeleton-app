<template>
  <ul>
    <RecipeItem v-for="recipe in recipes" :key="recipe.id" :recipe="recipe" />
  </ul>
</template>

<script setup>
import RecipeItem from "./RecipeItem.vue";
defineProps(["recipes"]);
</script>
