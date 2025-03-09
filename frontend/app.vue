<template>
  <div>
    <h1>Recipe Search</h1>
    
    <!-- Search Input -->
    <input v-model="searchQuery" placeholder="Search recipes..." />

    <div v-if="loading">Loading...</div>

    <!-- Display Results -->
    <div v-if="recipes.length">
      <ul>
        <li v-for="recipe in recipes" :key="recipe.id">
          <nuxt-link :to="'/recipes/' + recipe.slug">
            <h3>{{ recipe.name }}</h3>
          </nuxt-link>
          <p>{{ recipe.description }}</p>
          <!-- <p><strong>Ingredients:</strong> {{ recipe.ingredients.join(', ') }}</p> -->
        </li>
      </ul>
    </div>

    <p v-else-if="!loading && searchQuery">No results found.</p>
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
  if (!searchQuery.value) {
    recipes.value = [];
    return;
  }

  loading.value = true;
  try {
    const { data } = await axios.get(`http://localhost:8888/api/recipes/search`, {
      params: { q: searchQuery.value },
    });
    recipes.value = data.data; // Assuming Laravel API returns paginated data
    console.log({
      items: data.data,
      data,
      recipes
    })
  } catch (error) {
    console.error("Error fetching recipes:", error);
  }
  loading.value = false;
};

// Debounce the fetchRecipes function (1500ms delay)
const debouncedFetchRecipes = debounce(fetchRecipes, 750);

// Watch searchQuery and trigger the debounced function
watch(searchQuery, () => {
  debouncedFetchRecipes();
});
</script>
