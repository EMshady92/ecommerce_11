<script setup>
import { ref } from 'vue'; //importo ref de vue
import axios from 'axios';
import { onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import metricsbanner from '@/Pages/Cover/MetricsBanner.vue';
import navbarcover from '@/Pages/Cover/NavBarCover.vue';
import product_card from '@/Pages/Cover/ProducCard.vue';
import shopping_cart_counter from '@/Pages/Cover/ShoppingCartCounter.vue';
import list_products from '@/Pages/Products/ListProducts.vue';
defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});

const products = ref([]);
const showModal = ref(false);
const selectedProduct = ref(null);

const title = ref('');
const categoria = ref('');
const description = ref('');
const price = ref('');
const imageFile = ref(null);


function openModal(product) {
    selectedProduct.value = product;
    showModal.value = true;
    if (product) {
        title.value = product.title;
        categoria.value = product.categoria;
        description.value = product.description;
        price.value = product.price;
        imageFile.value = null; // Reset file input
    } else {
        title.value = '';
        categoria.value = '';
        description.value = '';
        price.value = '';
        imageFile.value = null;
    }
}

function createNewProduct() {
    selectedProduct.value = null;
    showModal.value = true;
    title.value = '';
    categoria.value = '';
    description.value = '';
    price.value = '';
    imageFile.value = null;
}

function closeModal() {
    showModal.value = false;
    selectedProduct.value = null;
}

function handleFileChange(event) {
    imageFile.value = event.target.files[0];
}
async function submitForm() {
    const formData = new FormData();
    formData.append('title', title.value);
    formData.append('categoria', categoria.value);
    formData.append('description', description.value);
    formData.append('price', price.value);
    if (imageFile.value) {
        formData.append('image', imageFile.value);
    }

    try {
        if (selectedProduct.value) {
            await axios.post(`update_product/${selectedProduct.value.id}`, formData);
        } else {
            await axios.post('save_product', formData);
        }
        closeModal();
        // Refresh products list
        const response = await axios.get('products_get');
        products.value = response.data;
    } catch (error) {
        console.error('Error saving product:', error);
    }
}

onMounted(async () => {
    try {
        const response = await axios.get('products_get');
        products.value = response.data;
    } catch (error) {
        console.error('Error fetching products:', error);
    }
});
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

                    <div class="flex justify-end mb-4">
                        <button @click="createNewProduct" class="bg-green-500 text-white px-4 py-2 rounded">Nuevo</button>
                    </div>

                    <list_products :headers="['Title', 'Categoria', 'Description', 'Price', 'Image_url']" :items="products" :openModal="openModal" />

                    <!-- <div class="grid grid-cols-3 gap-4">
                        <div @click="openModal" v-for="product in products" :key="product.id" class="border p-4 rounded">
                            <product_card  :product="product" class="hover:cursor-pointer" />
                        </div>
                    </div> -->

        </div>

    </div>


<!-- Modal -->
    <!-- Modal -->
    <div v-if="showModal" @click="closeModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white p-6 rounded shadow-lg w-1/2" @click.stop>
                <h2 class="text-2xl font-bold mb-4">{{ selectedProduct ? 'Editar Producto' : 'Nuevo Producto' }}</h2>
                <form @submit.prevent="submitForm">
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700">Title</label>
                        <input v-model="title" type="text" id="title" class="w-full p-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="categoria" class="block text-gray-700">Categoria</label>
                        <input v-model="categoria" type="text" id="categoria" class="w-full p-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-gray-700">Description</label>
                        <textarea v-model="description" id="description" class="w-full p-2 border rounded" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="price" class="block text-gray-700">Price</label>
                        <input v-model="price" type="number" step="0.01" id="price" class="w-full p-2 border rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="image_url" class="block text-gray-700">Image URL</label>
                        <input @change="handleFileChange" type="file" id="image_url" class="w-full p-2 border rounded">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Guardar</button>
                        <button type="button" @click="closeModal" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded">Cancelar</button>
                    </div>
                </form>
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
