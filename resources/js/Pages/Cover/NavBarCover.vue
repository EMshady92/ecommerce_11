<script setup>
import { Link } from '@inertiajs/vue3'; //importo el componente Link lo recibo de welcome

defineProps({  //los vuelvo a definir para recibirlos
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>
<template>
    <div class="w-full flex justify-between py-5 bg-[#f8f9fb]">
        <div class="w-1/3 flex">
            <div class="w-1/4"></div>
            <div class="w-1/4 place-content-center">Text-1</div>
            <div class="w-1/4 place-content-center">Text-2</div>
            <div class="w-1/4 place-content-center">Text-3</div>
        </div>
        <div class="w-1/3">

            <div v-if="canLogin" class="text-end z-10 mx-2">
                <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</Link>

                <template v-else>
                    <Link :href="route('login')" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-[#764abc] focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</Link>

                    <Link v-if="canRegister" :href="route('register')" class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-[#764abc] focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</Link>
                </template>
            </div>

        </div>
    </div>
</template>
