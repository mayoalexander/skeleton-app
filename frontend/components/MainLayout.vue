<template>
  <div class="flex min-h-full flex-col">
    <header class="shrink-0 border-b border-gray-200 bg-white">
      <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        
        <!-- 🍔 Mobile Menu Button (only shows on mobile) -->
        <button 
          @click="toggleSearch"
          class="lg:hidden -m-2.5 p-2.5 text-gray-600 hover:text-gray-900 search-button"
        >
          <span class="sr-only">Toggle Search</span>
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>

        <!-- 🏠 App Title -->
        <h1 class="text-xl font-semibold text-gray-800">Recipe Search 3000</h1>

        <!-- 🔐 Login Placeholder (Replaces User Icon) -->
        <button class="flex items-center gap-2 text-gray-700 hover:text-gray-900">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-8 0v2M12 3a4 4 0 1 1 0 8 4 4 0 0 1 0-8z" />
          </svg>
          <span class="hidden sm:inline">Login</span>
        </button>
      </div>
    </header>

    <!-- 🖥️ Desktop Layout (3-column setup remains on `lg:block`) -->
    <div class="mx-auto flex w-full items-start gap-x-8 px-4 py-10 sm:px-6 lg:px-8">
      
      <!-- 📏 Sidebar: Shows Search (ALWAYS visible on desktop, toggles on mobile) -->
      <aside 
        :class="[
          'lg:block lg:w-96 hidden',
          isSearchOpen ? 'block' : 'hidden lg:block'
        ]"
      >
        <slot name="search" />
      </aside>

      <!-- 📜 Main Content (Results) -->
      <main class="flex-1">
        <div class="block xl:hidden mb-4 selected-results">
            <slot name="selected" />
        </div>
        
        <slot name="results" />
      </main>

      <!-- 📌 Right Column: Selected Recipe (ALWAYS visible on desktop) -->
      <aside class="sticky top-8 hidden w-96 shrink-0 xl:block">
        <slot name="selected" />
      </aside>
    </div>

    <!-- 📱 Mobile Sidebar (ONLY shown on small screens) -->
    <div 
      v-if="isSearchOpen" 
      class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden" 
      @click="toggleSearch"
    ></div>

    <aside 
      :class="[
        'fixed inset-y-0 left-0 w-72 bg-white shadow-lg transform transition-transform z-50 lg:hidden',
        isSearchOpen ? 'translate-x-0' : '-translate-x-full'
      ]"
    >
      <div class="flex justify-end p-4 lg:hidden">
        <button @click="toggleSearch" class="text-gray-500 hover:text-gray-700">
          <span class="sr-only">Close</span>
          <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <slot name="search" />
    </aside>
  </div>
</template>

<script setup>
import { ref } from "vue";

// ✅ Sidebar State
const isSearchOpen = ref(false);
const toggleSearch = () => {
  isSearchOpen.value = !isSearchOpen.value;
};
</script>
