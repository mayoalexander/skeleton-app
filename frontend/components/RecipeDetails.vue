<template>
  <div class="p-6 rounded-b-lg shadow-lg border-t-4 border-yellow-400 bg-yellow-100">
    <h2 class="text-2xl font-bold">{{ recipe.name }}</h2>
    <p class="text-gray-700">{{ recipe.description }}</p>

    <p class="font-bold mt-4">Ingredients:</p>
    <ul class="list-disc pl-5">
      <li v-for="ingredient in recipe.ingredients" :key="ingredient.id">
        {{ ingredient.pivot.measure_amount }} {{ ingredient.pivot.measure_unit }} {{ ingredient.name }}
      </li>
    </ul>

    <p class="font-bold mt-4">Steps:</p>
    <ol class="list-decimal pl-5">
      <li v-for="step in recipe.steps" :key="step.id">
        Step {{ step.step_number }}: {{ step.description }}
      </li>
    </ol>
    <div>
        <p class="font-bold mt-4">Author:</p>{{  recipe.email }}
    </div>
  </div>
</template>

<script setup>
defineProps(["recipe"]);
</script>
