<script setup>
const model = defineModel();

defineProps({
    label: String,
    type: {
        type: String,
        default: "text",
    },
    placeholder: String,
});
</script>

<template>
    <label class="label">{{ label }}</label>
    <input
        class="input"
        :type="type"
        v-model="model"
        :placeholder="placeholder"
    />
</template>
