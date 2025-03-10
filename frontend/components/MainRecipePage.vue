<template>
  <div class="max-w-3xl mx-auto p-6">
    <RecipeSearch 
      v-model:keyword="keyword" 
      v-model:ingredient="ingredient" 
      v-model:authorEmail="authorEmail" 
    />

    <div v-if="loading" class="text-center mt-4">
      <p class="text-gray-500">Loading...</p>
    </div>

    <RecipeList :recipes="recipes" v-if="recipes.length" />

    <Pagination
        v-if="recipes.length"
      :prevPageUrl="prevPageUrl"
      :nextPageUrl="nextPageUrl"
      :currentPage="currentPage"
      :totalPages="totalPages"
      @paginate="fetchRecipes"
    />
  </div>
</template>

<script setup>
import { ref, watch, computed } from "vue";
import axios from "axios";
import { debounce } from "lodash";
import RecipeSearch from "./RecipeSearch.vue";
import RecipeList from "./RecipeList.vue";
import Pagination from "./Pagination.vue";

const keyword = ref("");
const ingredient = ref("");
const authorEmail = ref("");
const recipes = ref([]);
const loading = ref(false);
const currentPage = ref(1);
const totalPages = ref(1);
const prevPageUrl = ref(null);
const nextPageUrl = ref(null);

const hasSearched = computed(() => keyword.value || ingredient.value || authorEmail.value);

const fetchRecipes = async (url = "http://localhost:8888/api/recipes/search") => {
  loading.value = true;
  try {
    const params = { keyword: keyword.value, ingredient: ingredient.value, author_email: authorEmail.value };
    const { data } = await axios.get(url, { params });

    recipes.value = data.data;
    currentPage.value = data.current_page;
    totalPages.value = data.last_page;
    prevPageUrl.value = data.prev_page_url;
    nextPageUrl.value = data.next_page_url;
  } catch (error) {
    console.error("Error fetching recipes:", error);
  }
  loading.value = false;
};

watch([keyword, ingredient, authorEmail], debounce(() => fetchRecipes(), 1500));
</script>
