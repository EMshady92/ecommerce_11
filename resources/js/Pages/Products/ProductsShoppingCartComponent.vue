
<script setup>
import metricsbanner from '@/Pages/Cover/MetricsBanner.vue';
import navbarcover from '@/Pages/Cover/NavBarCover.vue';
import paypalcollapse from '@/Pages/PayPlatforms/PaypalCollapse.vue';
import { ref, computed, onMounted } from 'vue';
import axios from 'axios';

defineProps({
    csrfToken: String,
    canLogin: Boolean,
    canRegister: Boolean,
    products: Array,
    currencies: Array,
    canLogin: Boolean,
    canRegister: Boolean,
    paymentPlatforms: Array,
});

const endpoint = 'carrito/productos';
const products = ref([]);
const selectedPaymentPlatform = ref(null);
const components = {
    paypalcollapse, // Registra el componente manualmente para quee aparezca
};

const total = computed(() => {
  let cents = products.value.reduce((acumulador, currentObj) => {
    return acumulador + currentObj.numberPrice;
  }, 0);
  return `$${(cents).toFixed(2)}`;
});

const total_pay = computed(() => {
  let cents = products.value.reduce((acumulador, currentObj) => {
    return acumulador + currentObj.numberPrice;
  }, 0);
  return `${cents.toFixed(2)}`;
});

function fetchProducts() {
  axios.get(endpoint).then(response => {
    products.value = response.data.data;
    console.log(products.value);
  }).catch(error => {
    console.error('Error fetching products:', error);
  });
}

function selectPaymentPlatform(id) {
  selectedPaymentPlatform.value = id;
}

function getComponentName(name) {

    return `${name.toLowerCase()}collapse`;
}

onMounted(() => {
  fetchProducts();
});

</script>



<template>
    <div class="w-full h-screen flex justify-center">
    <div class="w-[80%]">
        <div class="">
            <metricsbanner />

        <navbarcover link="Link"
            :canLogin="canLogin"
            :canRegister="canRegister"
        />

        <div class="px-6 py-4 bg-white">
            <h1 class="text-lg font-semibold text-gray-700">CARRO DE COMPRAS</h1>
        </div>
        <div class="flex w-full">
            <div class="table-container h-screen w-1/2">
        <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nombre
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Descripción
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Precio
                        </th>

                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">

                    <tr v-for="product in products" :key="product.id">
                        <td class="px-6 whitespace-nowrap">
                            <div class="flex place-items-center">
                                    <div class="h-20 w-20">
                                        <img class="h-20 w-20 rounded-full object-cover object-center"
                                        :src="product.image" :alt="product.name">
                                    </div>

                                    <div class="ml-4">
                                        <div class="text-xl font-medium text-gray-900">
                                            {{ product.title }}
                                        </div>
                                    </div>
                                </div>
                        </td>
                        <td class="px-6 whitespace-nowrap">
                            <div class="flex place-items-center">
                                    <div class="ml-4">
                                        <div class="text-xl font-medium text-gray-900">
                                            {{ product.description }}
                                        </div>
                                    </div>
                                </div>
                        </td>

                        <td class="px-6 whitespace-nowrap">
                            <div class="flex place-items-center">
                                    <div class="ml-4">
                                        <div class="text-xl font-medium text-gray-900">
                                            {{ product.humanPrice }}
                                        </div>
                                    </div>
                                </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-xl whitespace-nowrap text-right font-semibold">Total</td>
                        <td class="px-6 py-4 whitespace-nowrap text-xl font-bold">{{ total }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

            <div class="table-container h-screen w-1/2">
                <form :action="route('pay')" method="POST" id="paymentForm" name="paymentForm">
                    <input type="hidden" name="_token" :value="csrfToken"> <!-- Añade el token CSRF aquí -->
                        <div class="w-full grid justify-items-center gap-x-2 mt-5 mx-3">
                            <div class="w-1/2 flex gap-x-2 place-items-center">
                                <label for="">Currency</label>
                                <select name="currency" id="currency" class="custom-select" required>
                                    <option value="" selected>Select</option>
                                    <option v-for="currency in currencies" :key="currency.id" :value="currency.iso">{{ currency.iso.toUpperCase() }}</option>

                                </select>
                            </div>

                            <div class="w-1/2">
                                    <label for="">Select the desired payment platform</label>
                                    <div class="form-group" id="toggler">
                                        <div class="space-x-2 flex" data-toggle="buttons">
                                            <label v-for="paymentPlatform in paymentPlatforms" :key="paymentPlatform.id"
                                                class="cursor-pointer inline-flex items-center justify-center border border-gray-500 text-gray-500 hover:bg-gray-500 hover:text-white rounded m-2 p-1">
                                                <input type="radio" name="payment_platform" :value="paymentPlatform.id" required
                                                    class="hidden" @change="selectPaymentPlatform(paymentPlatform.id)">
                                                <img class="img-thumbnail" :src="paymentPlatform.image">
                                            </label>
                                        </div>

                                        <!-- Renderizado dinámico del componente -->
                                        <div v-for="paymentPlatform in paymentPlatforms" :key="paymentPlatform.id">
                                            <div v-if="selectedPaymentPlatform === paymentPlatform.id">
                                                <component class="w-full" :is="components[getComponentName(paymentPlatform.name)]" />
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <input type="hidden" name="value" :value="total_pay"> <!-- Añade el valor total aquí -->

                        </div>
                        <div class="text-center mt-3">
                            <button type="submit" id="payButton" class="bg-[#764abc] text-white border border-transparent hover:bg-white hover:text-[#764abc] hover:border-[#764abc] py-3 px-6 rounded-md text-lg transition-all duration-300">Pay</button>
                        </div>
                </form>
            </div>

        </div>

    </div>
    </div>
    </div>


</template>
<style scoped>
.table-container {
  max-height: screen; /* Ajusta esta altura según tus necesidades */
  overflow-y: auto;
}
</style>
