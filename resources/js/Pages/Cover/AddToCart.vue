<script setup>

import { ref } from 'vue';
import axios from 'axios';
import { useStore } from 'vuex';

const props = defineProps({
  product: Object
});

const message = ref('Carrito');
const endpoint = ref('/in_shopping_carts');
const store = useStore();

function addToCart() {
  axios({
    url: endpoint.value,
    method: 'POST',
    data: {
      product_id: props.product.id
    },
    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    }
  }).then(() => {
    store.commit("increment"); // Increment the cart counter
  }).catch(error => {
    console.error('Error adding to cart:', error);
  });
}
</script>

<template>


    <button class="add-to-cart-btn" @click="addToCart">  <i class="fa-solid fa-cart-shopping mx-2"></i>{{message}}</button>


</template>


 <style scoped>
 .add-to-cart-btn {
    position: relative;
    border: 2px solid transparent;
    height: 40px;
    padding: 0 30px;
    background-color: #ef233c;
    color: #FFF;
    text-transform: uppercase;
    font-weight: 700;
    border-radius: 40px;
    -webkit-transition: 0.2s all;
    transition: 0.2s all;
  }

  .add-to-cart-btn:hover {
  background-color: #FFF;
  color: #D10024;
  border-color: #D10024;
  padding: 0px 30px 0px 50px;
}

.add-to-cart-btn:hover > i {
  opacity: 1;
  visibility: visible;
}
 </style>
