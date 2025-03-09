<template>
  <div class="max-w-3xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-4">Recipe Search</h1>

    <input v-model="keyword" placeholder="Keyword (name, description, steps, ingredients)..." class="w-full p-2 border rounded-md mb-2" />
    <input v-model="ingredient" placeholder="Ingredient..." class="w-full p-2 border rounded-md mb-2" />
    <input v-model="authorEmail" placeholder="Author email..." class="w-full p-2 border rounded-md mb-4" />

    <div v-if="loading" class="text-center mt-4">
      <p class="text-gray-500">Loading...</p>
    </div>

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
    <!-- <p v-else-if="!loading && hasSearched" class="text-red-500">No results found.</p> -->
  </div>
</template>

<script setup>
import { ref, watch, computed } from "vue";
import axios from "axios";
import { debounce } from "lodash";

const keyword = ref("");
const ingredient = ref("");
const authorEmail = ref("");
const recipes = ref([]);
const loading = ref(false);
const hasSearched = computed(() => keyword.value || ingredient.value || authorEmail.value);

const fetchRecipes = async () => {
  loading.value = true;
  try {
    const params = {};
    if (keyword.value) params.keyword = keyword.value;
    if (ingredient.value) params.ingredient = ingredient.value;
    if (authorEmail.value) params.author_email = authorEmail.value;

    const { data } = await axios.get('http://localhost:8888/api/recipes/search', { params });
    recipes.value = data.data;
  } catch (error) {
    console.error("Error fetching recipes:", error);
  }
  loading.value = false;
};

watch([keyword, ingredient, authorEmail], debounce(fetchRecipes, 1500));
</script>
