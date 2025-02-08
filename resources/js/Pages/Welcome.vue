<script setup>
import { Head, Link } from '@inertiajs/vue3';
import metricsbanner from '@/Pages/Cover/MetricsBanner.vue';
import navbarcover from '@/Pages/Cover/NavBarCover.vue';
import slider from '@/Pages/Cover/Slider.vue';
import product_card from '@/Pages/Cover/ProducCard.vue';
import shopping_cart_counter from '@/Pages/Cover/ShoppingCartCounter.vue';
defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    products: Array,
    productsCount: Number
});
</script>

<template>
    <Head title="Welcome" />


    <div class="w-full h-screen flex justify-center">
        <div class="w-[80%]">
            <div class="floating">

<a  class="btn-fab py-2">
    <i class="fa-solid fa-cart-shopping py-2"></i>
    <shopping_cart_counter :count="productsCount"></shopping_cart_counter> <!-- Usa productsCount aquí -->

</a>
<!-- <product-counter-component onMouseover="this.style.color='red'" onMouseout="this.style.color='white'" :count="{{$productsCount}}"></product-counter-component>
 --></div>
            <metricsbanner />

            <navbarcover link="Link"
                :canLogin="canLogin"
                :canRegister="canRegister"
            />

            <slider class="mt-2"/>

           <div class="grid grid-cols-4 gap-4">
            <div v-for="product in products" :key="product.id" class="border p-4 rounded">
                <product_card :product="product" />

                </div>

           </div>

        </div>
    </div>

    <!-- <div class="sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:end-0 p-6 text-end z-10">
            <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</Link>

            <template v-else>
                <Link :href="route('login')" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</Link>

                <Link v-if="canRegister" :href="route('register')" class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</Link>
            </template>
        </div>

        <div class="max-w-7xl mx-auto p-6 Zg:p-8">

            <div class="flexslider hidden xl:block" style="height: 420px !important;">
            <ul class="slides" style="height: 350px !important;">
                <li>
                    <a href="{{ route('offers') }}">
                        <img style="width: 1200px; height: 410px;" class=""
                            src="{{ asset('images/banner.jpg') }}" />
                    </a>
                </li>
            </ul>
            </div>
        </div>
    </div> -->
</template>

<style scoped>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}

.floating{

position:fixed;
top:2em;
right:5em;
z-index:100;

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
