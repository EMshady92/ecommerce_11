<script setup>

import metricsbanner from '@/Pages/Cover/MetricsBanner.vue';
import navbarcover from '@/Pages/Cover/NavBarCover.vue';

defineProps({
    order: Array,
});

</script>
<template>
    <Head title="Ticket" />
    <metricsbanner />

    <navbarcover link="Link"
        :canLogin="canLogin"
        :canRegister="canRegister"
    />


    <div class="w-full h-screen flex justify-center">
        <div class="w-[80%]">
                <div class="purchase-ticket">
                    <div class="ticket-header">
                        <h2>Ticket de Compra</h2>
                    </div>
                    <div class="ticket-body">
                        <div class="ticket-row">
                        <span class="label">Nombre:</span>
                        <span class="value">{{ order.name }}</span>
                        </div>
                        <div class="ticket-row">
                        <span class="label">Total:</span>
                        <span class="value">{{ order.total }} {{ order.currency }}</span>
                        </div>
                        <div class="ticket-row">
                        <span class="label">Email:</span>
                        <span class="value">{{ order.email }}</span>
                        </div>
                    </div>
                    <div class="ticket-footer">
                        <p>¡Gracias por su compra!</p>
                    </div>
                </div>
        </div>


    </div>
  </template>



  <style scoped>
  .purchase-ticket {
    border: 2px solid #ccc;
    border-radius: 10px;
    padding: 20px;
    max-width: 300px;
    margin: 0 auto;
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .ticket-header {
    text-align: center;
    border-bottom: 1px dashed #ccc;
    padding-bottom: 10px;
    margin-bottom: 15px;
  }

  .ticket-header h2 {
    margin: 0;
    font-size: 1.5rem;
    color: #333;
  }

  .ticket-body {
    margin-bottom: 15px;
  }

  .ticket-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
  }

  .ticket-row .label {
    font-weight: bold;
    color: #555;
  }

  .ticket-row .value {
    color: #333;
  }

  .ticket-footer {
    text-align: center;
    border-top: 1px dashed #ccc;
    padding-top: 10px;
    font-style: italic;
    color: #777;
  }
  </style>
