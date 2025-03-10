<template>
  <div class="search-container">
    <UtilityInput 
      :modelValue="keyword"
      @update:modelValue="$emit('update:keyword', $event)"
      label="Keyword" 
      placeholder="Search by name, description, steps, ingredients..." 
    />

    <UtilityInput 
      :modelValue="ingredient"
      @update:modelValue="$emit('update:ingredient', $event)"
      label="Ingredient" 
      placeholder="Search by ingredient..." 
    />

    <UtilityInput 
      :modelValue="authorEmail"
      @update:modelValue="$emit('update:authorEmail', $event)"
      label="Author Email" 
      placeholder="Enter author email..." 
    />
  </div>
</template>

<script setup>
defineProps(["keyword", "ingredient", "authorEmail"]);
defineEmits(["update:keyword", "update:ingredient", "update:authorEmail"]);
</script>
