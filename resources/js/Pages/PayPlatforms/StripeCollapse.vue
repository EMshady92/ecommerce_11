
<script setup>
import { ref, onMounted  } from 'vue';

const props = defineProps({
  keyStripe: String, // keyStripe es una prop de tipo String
});

const stripe = ref(null);
const elements = ref(null);
const cardElement = ref(null);

onMounted(async () => {

  // Cargar el script de Stripe
  const script = document.createElement('script');
  script.src = 'https://js.stripe.com/v3/';
  script.onload = async () => {
    stripe.value = Stripe(props.keyStripe);
    elements.value = stripe.value.elements({ locale: 'en' });
    cardElement.value = elements.value.create('card');
    cardElement.value.mount('#cardElement');

    const form = document.getElementById('paymentForm');
    const payButton = document.getElementById('payButton');

     payButton.addEventListener('click', async (e) => {
      e.preventDefault();

      const { paymentMethod, error } = await stripe.value.createPaymentMethod(
        'card', cardElement.value, {  //
                    billing_details: {
                        "name": "Daniel",
                        "email": "lordramsay@outlook.com"
                    }
                });

      if (error) {
        document.getElementById('cardErrors').textContent = error.message;
      } else {
        document.getElementById('paymentMethod').value = paymentMethod.id;
        form.submit();
      }
    });
  };
  document.head.appendChild(script);
});

</script>
<template>
<label class="mt-3">Card details:</label>
<div id="cardElement"></div>
<small class="form-text text-muted" id="cardErrors" role="alert"></small>
<input type="hidden" name="payment_method" id="paymentMethod">

<!-- <script setup src="https://js.stripe.com/v3/"></script>
<script setup>
    const stripe = Stripe('{{ config('services.stripe.key') }}'); //traigo la key  de services

    const elements = stripe.elements({locale: 'en'}); // trae idioma de stripe
    const cardElement = elements.create('card'); //  usa metodo create de stripe para crear una  card

    cardElement.mount('#cardElement'); //la montda en el id  cardElement
</script>

<script setup>
    const form = document.getElementById('paymentForm'); //elemento formulario
    const payButton = document.getElementById('payButton'); //elemento paybutton

    payButton.addEventListener('click', async(e) => {  //se activa una funcion asincrona al momento  de hacer click en pay


    });
</script> -->

<!-- <style scoped>
    /**
     * The CSS shown here will not be introduced in the Quickstart guide, but shows
     * how you can use CSS to style your Element's container.
     */
    .StripeElement {
      box-sizing: border-box;

      height: 40px;

      padding: 10px 12px;

      border: 1px solid transparent;
      border-radius: 4px;
      background-color: white;

      box-shadow: 0 1px 3px 0 #e6ebf1;
      -webkit-transition: box-shadow 150ms ease;
      transition: box-shadow 150ms ease;
    }

    .StripeElement--focus {
      box-shadow: 0 1px 3px 0 #cfd7df;
    }

    .StripeElement--invalid {
      border-color: #fa755a;
    }

    .StripeElement--webkit-autofill {
      background-color: #fefde5 !important;
    }
</style>-->
</template>
