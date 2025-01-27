<script setup>
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
     <article class="max-w-sm w-full bg-white rounded-lg shadow-lg overflow-hidden">
    <div>
      <!-- <img class="object-cover h-64 w-full" src="{{product.image_url}}'" alt="Converse sneakers" /> -->
      <img class="object-cover h-64 w-full" :src="product.image_url" :alt="product.name" />

    </div>

    <div class="flex flex-col gap-1 mt-4 px-4">
      <h2 class="text-lg font-semibold text-gray-800 ">{{product.title}} Sneakers</h2>
      <span class="font-normal text-gray-600 ">{{product.description}}</span>
      <span class="font-semibold text-gray-800">{{ formatPrice(product.price) }}</span>

    </div>

    <div class="flex gap-4 mt-4 px-4">
      <span class="sr-only">Colors available</span>

      <button aria-label="Yellow" class="p-1 border border-gray-200  rounded-full cursor-pointer bg-yellow-500 "></button>

      <button aria-label="Red" class="p-1 border border-gray-200  rounded-full cursor-pointer bg-red-500 "></button>

      <button aria-label="Blue" class="p-1 border border-gray-200  rounded-full cursor-pointer bg-blue-500 "></button>

      <button aria-label="Black" class="p-1 border border-gray-200  rounded-full cursor-pointer bg-gray-800 "></button>
    </div>

    <div class="mt-4 p-4 border-t border-gray-200 ">
      <button class="w-1/3 rounded-md px-1 bg-red-500 flex justify-between items-center font-bold cursor-pointer hover:underline text-white">
        <span class="text-base">Add to Cart</span>
        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
      </button>
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

