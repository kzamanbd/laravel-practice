<script setup>
    defineProps({
        groups: {
            type: Array,
            default: () => []
        }
    });
</script>

<template>
    <h1>{{ groups }}</h1>
</template>
