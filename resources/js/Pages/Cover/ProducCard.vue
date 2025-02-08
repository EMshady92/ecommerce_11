<script setup>

import add_to_cart from '@/Pages/Cover/AddToCart.vue';

defineProps({
    product: Object
});

function formatPrice(value) { // 12345.67 => $12,345.67 fornato  de moneda
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(value);
}
</script>
<template>
     <article class="w-full bg-white rounded-lg shadow-lg overflow-hidden">
            <div>
                <img class="object-cover h-64 w-full" :src="product.image_url" :alt="product.name" />
            </div>

            <div class="flex flex-col gap-1 mt-4 px-4">
                <h2 class="text-lg font-semibold text-gray-800 ">{{ product.title }}</h2>
                <span class="font-normal text-gray-600 ">{{ product.description }}</span>
                <span class="font-semibold text-gray-800">{{ formatPrice(product.price) }}</span>
            </div>

            <div class="flex items-center mt-2  mx-1">
            <span v-for="star in 5" :key="star" class="text-yellow-500">
                <svg v-if="star <= rating" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                </svg>
            </span>
            </div>

            <div class="mt-4 p-4 border-t border-gray-200 ">
                <add_to_cart :product="product"/>
            </div>
  </article>
  </template>

  <script>
  export default {
    name: "ProductCard",
    props: {
      image: {
        type: String,
        required: true
      },
      title: {
        type: String,
        required: true
      },
      description: {
        type: String,
        required: true
      },
      price: {
        type: String,
        required: true
      }
    },
    methods: {
      addToCart() {
        this.$emit('add-to-cart');
      }
    }
  };
  </script>

