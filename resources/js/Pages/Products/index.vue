<script setup>
import { ref } from 'vue'; //importo ref de vue
import { Head, Link } from '@inertiajs/vue3';
import metricsbanner from '@/Pages/Cover/MetricsBanner.vue';
import navbarcover from '@/Pages/Cover/NavBarCover.vue';
import product_card from '@/Pages/Cover/ProducCard.vue';
import shopping_cart_counter from '@/Pages/Cover/ShoppingCartCounter.vue';
import list_products from '@/Pages/Products/ListProducts.vue';
defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    products: Array
});

const showModal = ref(false);
const selectedProduct = ref(null);

function openModal(product) {
    selectedProduct.value = product;
    showModal.value = true;
}

function closeModal() {
    showModal.value = false;
    selectedProduct.value = null;
}
</script>

<template>
    <Head title="Products" />

    <div class="w-full h-screen flex justify-center">
                    <div class="w-[80%]">

                    <metricsbanner/>

                    <navbarcover link="Link"
                        :canLogin="canLogin"
                        :canRegister="canRegister"
                    />
                    <div class="flex justify-start my-4">
                        <button @click="createNewProduct" class="bg-green-500 text-white px-4 py-2 rounded">Nuevo</button>
                    </div>
                    <list_products :headers="['Title','Categoria', 'Description', 'Price','image_url']" :items="products" />

                    <!-- <div class="grid grid-cols-3 gap-4">
                        <div @click="openModal" v-for="product in products" :key="product.id" class="border p-4 rounded">
                            <product_card  :product="product" class="hover:cursor-pointer" />
                        </div>
                    </div> -->

        </div>

    </div>

    <!-- Modal -->
    <div v-if="showModal" @click="closeModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded shadow-lg w-1/2">
            <h2 class="text-2xl font-bold mb-4">215</h2>
            <p>14145</p>
            <p class="text-gray-500">155</p>
            <button @click="closeModal" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">Close</button>
        </div>
    </div>

</template>

<style scoped>

.floating{

position:fixed;
top:2em;
right:5em;
z-index:100;
width:80px; ;
}

.btn-fab{
border: 2px solid transparent;
height: 100px;
padding: 10px 10px;
background-color: #D10024;
color: #FFF;
text-transform: uppercase;
font-weight: 700;
border-radius: 100%;
-webkit-transition: 0.2s all;
transition: 0.2s all;
  border: none;
  border-radius: 40px 40px 40px 40px;
}
.btn-fab:hover {
background-color: #D10024;
color: #FFF;
border-color: #D10024;
padding: 10px 10px;
}
</style>
