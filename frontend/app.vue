<template>
  <MainLayout>
    <MainRecipePage />
  </MainLayout>
</template>

<script setup>
import { ref, watch, computed } from "vue";
import axios from "axios";
import { debounce } from "lodash";
import MainRecipePage from "./components/MainRecipePage.vue";
import MainLayout from "./components/MainLayout.vue";

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
