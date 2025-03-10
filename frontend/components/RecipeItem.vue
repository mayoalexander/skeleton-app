<template>
  <li class="recipe-card">
    <h2 class="text-2xl font-semibold">{{ recipe.name }}</h2>
    <p class="text-gray-600 italic">{{ recipe.description }}</p>

    <p class="font-bold mt-3">Ingredients:</p>
    <ul class="list-disc pl-5">
      <li v-for="ingredient in recipe.ingredients" :key="ingredient.id">
        {{ ingredient.pivot.measure_amount }} {{ ingredient.pivot.measure_unit }} {{ ingredient.name }}
      </li>
    </ul>

    <p class="font-bold mt-3">Steps:</p>
    <ol class="list-decimal pl-5">
      <li v-for="step in recipe.steps" :key="step.id">
        Step {{ step.step_number }}: {{ step.description }}
      </li>
    </ol>
  </li>
</template>

<script setup>
defineProps(["recipe"]);
</script>

<style scoped>
.recipe-card {
  @apply mb-6 p-4 border rounded-lg shadow-md;
}
</style>
