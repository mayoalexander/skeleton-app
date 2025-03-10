<template>
  <div class="">
    <MainLayout>
        <template #search>
            <RecipeSearch 
                v-model:keyword="keyword" 
                v-model:ingredient="ingredient" 
                v-model:authorEmail="authorEmail" 
            />
        </template>    
        <template #results>
            <RecipeList :recipes="recipes" v-if="recipes.length" />
            <UtilityLoadingSpinner v-if="loading" />
            <Pagination
                v-if="recipes.length"
                :prevPageUrl="prevPageUrl"
                :nextPageUrl="nextPageUrl"
                :currentPage="currentPage"
                :totalPages="totalPages"
                @paginate="fetchRecipes"
            />
        </template>    
    </MainLayout>
  </div>
</template>

<script setup>
import { ref, watch } from "vue";
import axios from "axios";
import { debounce } from "lodash";
import RecipeSearch from "./RecipeSearch.vue";
import RecipeList from "./RecipeList.vue";
import UtilityLoadingSpinner from "./Utility/LoadingSpinner.vue";
import MainLayout from "./MainLayout.vue";
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

const fetchRecipes = async () => {
  loading.value = true;
  try {
    const url = "http://localhost:8888/api/recipes/search"
    const params = { keyword: keyword.value, ingredient: ingredient.value, author_email: authorEmail.value };
    const { data } = await axios.get(url, { params });

    console.log({
        data,
        url
    })
    
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

// ✅ Watch for input changes with debounce
watch([keyword, ingredient, authorEmail], debounce(fetchRecipes, 1500));
</script>


