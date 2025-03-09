<template>
  <div class="max-w-3xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-4">Recipe Search</h1>

    <input v-model="searchQuery" placeholder="Search recipes..." class="w-full p-2 border rounded-md" />

    <div v-if="loading" class="text-center mt-4">
      <p class="text-gray-500">Loading...</p>
    </div>

    <div v-if="recipes.length">
      <ul>
        <li v-for="recipe in recipes" :key="recipe.id" class="mb-6 p-4 border rounded-lg shadow-md">
          <h2 class="text-2xl font-semibold">{{ recipe.name }}</h2>
          <p class="text-gray-600 italic">{{ recipe.description }}</p>

          <!-- Ingredients -->
          <p class="font-bold mt-3">Ingredients:</p>
          <ul class="list-disc pl-5">
            <li v-for="ingredient in recipe.ingredients" :key="ingredient.id">
              {{ ingredient.pivot.measure_amount }} {{ ingredient.pivot.measure_unit }} {{ ingredient.name }}
            </li>
          </ul>

          <!-- Steps -->
          <p class="font-bold mt-3">Steps:</p>
          <ol class="list-decimal pl-5">
            <li v-for="step in recipe.steps" :key="step.id">
              Step {{ step.step_number }}: {{ step.description }}
            </li>
          </ol>
        </li>
      </ul>
    </div>

    <p v-else-if="!loading && searchQuery" class="text-red-500">No results found.</p>
  </div>
</template>

<script setup>
import { ref, watch } from "vue";
import axios from "axios";
import { debounce } from "lodash";

const searchQuery = ref("");
const recipes = ref([]);
const loading = ref(false);

const fetchRecipes = async () => {
  loading.value = true;
  try {
    const { data } = await axios.get(`http://localhost:8888/api/recipes/search`, {
      params: { keyword: searchQuery.value }
    });
    console.log({
      data
    })
    recipes.value = data.data;
  } catch (error) {
    console.error("Error fetching recipes:", error);
  }
  loading.value = false;
};

watch(searchQuery, debounce(fetchRecipes, 1500));
</script>
