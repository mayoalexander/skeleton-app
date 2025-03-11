<template>
  <div class="flex flex-col gap-4 animate-pulse">
    <div class="h-6 w-3/4 bg-gray-300 rounded-md"></div>
    <div class="h-4 w-full bg-gray-300 rounded-md"></div>
    <div class="h-4 w-5/6 bg-gray-300 rounded-md"></div>
    <div class="h-4 w-2/3 bg-gray-300 rounded-md"></div>
    <div class="h-4 w-3/4 bg-gray-300 rounded-md"></div>
  </div>
</template>

<style scoped>
/* This makes the blocks animate smoothly */
.animate-pulse {
  animation: pulse 1.5s infinite ease-in-out;
}

@keyframes pulse {
  0% {
    opacity: 0.6;
  }
  50% {
    opacity: 1;
  }
  100% {
    opacity: 0.6;
  }
}
</style>
