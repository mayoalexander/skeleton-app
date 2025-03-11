<template>
  <div class="search-container">

    <UtilityPageHeader>Search Recipes</UtilityPageHeader>
    
    <UtilityInput 
      :modelValue="keyword"
      @update:modelValue="$emit('update:keyword', $event)"
      label="Keyword" 
      placeholder="Search by name, description, steps, ingredients..." 
    />

    <UtilityInput 
      :modelValue="authorEmail"
      @update:modelValue="$emit('update:authorEmail', $event)"
      label="Author Email" 
      placeholder="Enter author email..." 
    />

    <UtilityInput 
      :modelValue="ingredient"
      @update:modelValue="$emit('update:ingredient', $event)"
      label="Ingredient" 
      placeholder="Search by ingredient..." 
    />

    <div class="ingredient-selectors">
      <UtilityLabel>Select Ingredients</UtilityLabel>
      <div 
        v-for="item in ingredients" :key="item.id"
        class="px-4 py-2 rounded-md inline-block mb-2 mr-2 hover:cursor-pointer ingredient-item"
        :class="{
          'bg-yellow-200 text-gray-800': item.name === ingredient,
          'bg-gray-100 text-gray-700 hover:bg-yellow-100 hover:text-gray-800': item.name !== ingredient
        }"
        @click="$emit('update:ingredient', item.name)">
        {{ item.name }}
    </div>
    </div>

  </div>
</template>

<script setup>
import { UtilityPageHeader } from '#components';

defineProps(["keyword", "ingredient", "authorEmail", 'ingredients']);
defineEmits(["update:keyword", "update:ingredient", "update:authorEmail"]);
</script>
