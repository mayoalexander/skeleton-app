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

        <UtilityLoadingSpinner v-if="loading"/>

        <Pagination
          v-if="recipes.length"
          :prevPageUrl="prevPageUrl"
          :nextPageUrl="nextPageUrl"
          :currentPage="currentPage"
          :totalPages="totalPages"
          @paginate="paginate"
        />
      </template>    

      <template #selected>
        <transition name="fade-slide" mode="out-in">
          <RecipeDetails v-if="selectedRecipe" :recipe="selectedRecipe" :key="selectedRecipe.id" />
        </transition>
      </template>    
    </MainLayout>
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from "vue";
import { useRoute, useRouter } from "#app";
import axios from "axios";
import { debounce } from "lodash";
import RecipeSearch from "./RecipeSearch.vue";
import RecipeList from "./RecipeList.vue";
import RecipeDetails from "./RecipeDetails.vue";
import UtilityLoadingSpinner from "./Utility/LoadingSpinner.vue";
import UtilityNoResultsFound from "./Utility/NoResultsFound.vue";
import MainLayout from "./MainLayout.vue";
import Pagination from "./Pagination.vue";

const route = useRoute();
const router = useRouter();

const keyword = ref("");
const ingredient = ref("");
const authorEmail = ref("");
const recipes = ref([]);
const allIngredients = ref([]);
const loading = ref(false);
const pendingSearch = ref(false);
const currentPage = ref(1);
const totalPages = ref(1);
const prevPageUrl = ref(null);
const nextPageUrl = ref(null);
const selectedRecipe = ref(null);

const selectRecipe = (recipe) => {
  selectedRecipe.value = recipe;
  router.push({
    path: `/recipes/${recipe.slug}`,
  });
};

const fetchIngredients = async () => {
  try {
    const { data } = await axios.get("http://localhost:8888/api/ingredients");
    allIngredients.value = data;
  } catch (error) {
    console.error("Error fetching ingredients:", error);
  }
};

const fetchRecipes = async (page = 1) => {
  recipes.value = [];
  loading.value = true;
  pendingSearch.value = false;
  currentPage.value = page;

  try {
    const params = {
      keyword: keyword.value || null,
      ingredient: ingredient.value || null,
      author_email: authorEmail.value || null,
      page: page > 1 ? page : null,
    };

    const { data } = await axios.get("http://localhost:8888/api/recipes/search", { params });

    recipes.value = data.data;
    totalPages.value = data.last_page;
    prevPageUrl.value = data.prev_page_url;
    nextPageUrl.value = data.next_page_url;

  } catch (error) {
    console.error("Error fetching recipes:", error);
  }
  loading.value = false;
};

// ✅ Load query parameters when the page loads
onMounted(async () => {
  await fetchIngredients();

  
  
  // ✅ Check if search params exist and load them
  keyword.value = route.query.keyword || "";
  ingredient.value = route.query.ingredient || "";
  authorEmail.value = route.query.author_email || "";
  currentPage.value = route.query.page ? parseInt(route.query.page) : 1;

  // TODO: always fetch recipes, but only apply the 
  await fetchRecipes(currentPage.value);

  // ✅ If a recipe slug is in the URL, fetch it
  if (route.path.includes('/recipes/')) {
    const slug = route.path.replace('/recipes/', '')
    // const selectedRecipe = 
    console.log({
      slug,
      recipes,
      found: recipes.value.find(item => item.slug === slug),
      // route: route,
      setSelected: true,
      path: route.path.replace('/recipes/', '')
    })
    selectedRecipe.value = recipes.value.find(item => item.slug === slug)
  }
});

// ✅ Watch for input changes and update the URL
watch([keyword, ingredient, authorEmail], () => {
  recipes.value = [];
  loading.value = true;
  pendingSearch.value = true;
  
  // update the URL
  router.push({
    path: `/`,
    query: Object.fromEntries(
      Object.entries({
        keyword: keyword.value || null,
        ingredient: ingredient.value || null,
        author_email: authorEmail.value || null,
        page: currentPage.value > 1 ? currentPage.value : null, // Only add page if > 1
      }).filter(([_, v]) => v !== null) // ✅ Remove null values
    ),
  });
  
  debouncedFetch();
});

const paginate = (pageData) => {
  console.log({ pageData });

  // Merge the existing query parameters with the new page value
  router.push({
    path: `/`,
    query: {
      ...route.query, // Retain existing query parameters
      page: pageData, // Update only the page parameter
    },
  });

  fetchRecipes(pageData);
};


// ✅ Debounced function to prevent flickering
const debouncedFetch = debounce(() => {
  pendingSearch.value = false;
  fetchRecipes(1);
}, 1500);
</script>
<style scoped>
/* ✨ Fade and Slide Animation */
.fade-slide-enter-active, .fade-slide-leave-active {
  transition: opacity 0.25s ease, transform 0.25s ease;
}

.fade-slide-enter-from {
  opacity: 0;
  transform: translateX(-20px);
}

.fade-slide-leave-to {
  opacity: 0;
  transform: translateX(40px);
}
</style>