<template>
  <div class="w-full mb-4">
    <label v-if="label" class="block text-gray-700 font-medium mb-1">
      {{ label }} <span v-if="required" class="text-red-500">*</span>
    </label>
    <input
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      :type="type"
      :placeholder="placeholder"
      :required="required"
      class="w-full p-2 border rounded-md focus:ring focus:ring-indigo-200 utility-input"
    />
  </div>
</template>

<script setup>
defineProps({
  modelValue: String,
  label: String,
  placeholder: String,
  required: Boolean,
  type: { type: String, default: "text" },
});
defineEmits(["update:modelValue"]);
</script>
