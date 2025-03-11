<template>
  <div class="">
    <MainLayout>
        <template #search>
            <RecipeSearch 
                v-model:keyword="keyword" 
                v-model:ingredient="ingredient" 
                v-model:authorEmail="authorEmail" 
                :ingredients="allIngredients" 
            />
        </template>    

        <template #results>
            
            <RecipeList 
                :recipes="recipes" 
                @selectRecipe="selectRecipe"
                v-if="recipes.length || pendingSearch" 
            />

            <UtilityNoResultsFound v-if="!loading && !pendingSearch && recipes.length === 0 && (keyword || ingredient || authorEmail)" />

            <UtilityLoadingSpinner v-if="loading && !pendingSearch" />

            <Pagination
                v-if="recipes.length"
                :prevPageUrl="prevPageUrl"
                :nextPageUrl="nextPageUrl"
                :currentPage="currentPage"
                :totalPages="totalPages"
                @paginate="fetchRecipes"
            />
        </template>    

        <template #selected>
            <RecipeDetails v-if="selectedRecipe" :recipe="selectedRecipe" />
            <p v-else class="text-gray-500 text-center">Select a recipe to view details.</p>
        </template>    
    </MainLayout>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from "vue";
import axios from "axios";
import { debounce } from "lodash";
import RecipeSearch from "./RecipeSearch.vue";
import RecipeList from "./RecipeList.vue";
import RecipeDetails from "./RecipeDetails.vue";
import UtilityLoadingSpinner from "./Utility/LoadingSpinner.vue";
import UtilityNoResultsFound from "./Utility/NoResultsFound.vue";
import MainLayout from "./MainLayout.vue";
import Pagination from "./Pagination.vue";

const keyword = ref("");
const ingredient = ref("");
const authorEmail = ref("");
const recipes = ref([]);
const allIngredients = ref([]); // ✅ Store all ingredients
const loading = ref(false);
const pendingSearch = ref(false);
const currentPage = ref(1);
const totalPages = ref(1);
const prevPageUrl = ref(null);
const nextPageUrl = ref(null);

// ✅ Track the selected recipe
const selectedRecipe = ref(null);

// ✅ Function to update the selected recipe
const selectRecipe = (recipe) => {
  selectedRecipe.value = recipe;
};

// ✅ Fetch all ingredients when component mounts
const fetchIngredients = async () => {
  try {
    const { data } = await axios.get("http://localhost:8888/api/ingredients");
    allIngredients.value = data;
  } catch (error) {
    console.error("Error fetching ingredients:", error);
  }
};

// ✅ Fetch recipes from API
const fetchRecipes = async () => {
  loading.value = true;
  pendingSearch.value = false;

  try {
    const params = { keyword: keyword.value, ingredient: ingredient.value, author_email: authorEmail.value };
    const { data } = await axios.get("http://localhost:8888/api/recipes/search", { params });

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

// ✅ Debounced search function
const debouncedFetch = debounce(() => {
  pendingSearch.value = false;
  fetchRecipes();
}, 1500);

// ✅ Fetch ingredients when the component mounts
onMounted(() => {
  fetchIngredients();
});

// ✅ Watch for input changes, but prevent flickering
watch([keyword, ingredient, authorEmail], () => {
  pendingSearch.value = true;
  debouncedFetch();
});
</script>
