<script setup>
defineProps({
    headers: Array,
    items: Array
});

function formatPrice(value) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(value);
}


</script>

<template>

<div class="mb-4">
        <input
            v-model="searchQuery"
            type="text"
            placeholder="Buscar productos..."
            class="w-1/4 p-2 border rounded"
        />
    </div>

    <table class="min-w-full bg-gray-100 rounded-md">
        <thead>
            <tr>
                <th v-for="header in headers" :key="header" class="text-xl py-2 px-4 border-b font-bold">{{ header }}</th>
                <th class="text-xl py-2 px-4 border-b font-bold">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in items" :key="item.id">
                <td v-for="header in headers" :key="header" class="py-2 px-4 border-b text-center">
                    <template v-if="header.toLowerCase() === 'image_url'">
                        <img :src="item[header.toLowerCase()]" alt="Product Image" class="h-16 w-16 object-cover mx-auto">
                    </template>
                    <template v-else-if="header.toLowerCase() === 'price'">
                        {{ formatPrice(item[header.toLowerCase()]) }}
                    </template>
                    <template v-else>
                        {{ item[header.toLowerCase()] }}
                    </template>
                </td>
                <td class="py-2 px-4 border-b text-center">
                    <button @click="handleButtonClick(item)" class="bg-blue-500 text-white px-2 py-1 rounded">Edit</button>
                </td>
            </tr>
        </tbody>
    </table>
</template>
<style scoped>
.min-w-full {
    min-width: 100%;
}

.bg-white {
    background-color: white;
}

.py-2 {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
}

.px-4 {
    padding-left: 1rem;
    padding-right: 1rem;
}

.border-b {
    border-bottom: 1px solid #e5e7eb;
}

.bg-blue-500 {
    background-color: #3b82f6;
}

.text-white {
    color: white;
}

.px-2 {
    padding-left: 0.5rem;
    padding-right: 0.5rem;
}

.py-1 {
    padding-top: 0.25rem;
    padding-bottom: 0.25rem;
}

.rounded {
    border-radius: 0.25rem;
}

.text-left {
    text-align: left;
}
</style>
