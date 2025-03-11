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
                @paginate="fetchRecipes"
            />
        </template>    

        <template #selected>
            <RecipeDetails v-if="selectedRecipe" :recipe="selectedRecipe" />
            <!-- <p v-else class="text-gray-500 text-center">Select a recipe to view details.</p> -->
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

const route = useRoute(); // ✅ Use Nuxt's `useRoute()`
const router = useRouter();


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

  console.log({
    recipe
  })
  
    // ✅ Update URL when selecting a recipe
  router.push({
    path: `/recipes/${recipe.slug}`, // Update to use recipe slug
    // query: { 
    //   keyword: keyword.value, 
    //   ingredient: ingredient.value, 
    //   author_email: authorEmail.value,
    //   page: currentPage.value,
    //   recipeSlug: recipe.slug // ✅ Save selected recipe in query
    // },
  });
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

// ✅ Fetch recipes from API (Handles pagination properly)
const fetchRecipes = async (page = 1) => {
  loading.value = true;
  pendingSearch.value = false;
  currentPage.value = page; // ✅ Set current page properly

  try {


    router.push({
      path: `/`,
      query: Object.fromEntries(
        Object.entries({
          keyword: keyword.value || null,
          ingredient: ingredient.value || null,
          author_email: authorEmail.value || null,
          page: currentPage.value > 1 ? currentPage.value : null, // Only add page if > 1
          recipeSlug: selectedRecipe.value?.slug || null, // Only add if a recipe is selected
        }).filter(([_, v]) => v !== null) // ✅ Remove null values
      ),
    });
    
    const params = { 
      keyword: keyword.value, 
      ingredient: ingredient.value, 
      author_email: authorEmail.value,
      page: page // ✅ Pass page parameter
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

// ✅ Debounced search function
const debouncedFetch = debounce(() => {
  pendingSearch.value = false;
  
  // if still searching, update the URL

  // if seelcted, set the URL to the detail
  
  fetchRecipes(1); // ✅ Always reset to page 1 when searching
}, 1500);

// ✅ Fetch ingredients when the component mounts
onMounted(() => {
  fetchIngredients();
});

// ✅ Watch for input changes, but prevent flickering
watch([keyword, ingredient, authorEmail, selectedRecipe], () => {
  recipes.value = []
  loading.value = true
  pendingSearch.value = true;
  debouncedFetch();
});
</script>
