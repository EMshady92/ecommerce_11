  <script setup>
  import { computed } from 'vue';
  import { useStore } from 'vuex';

const props = defineProps({
  count: Number
});

const store = useStore();

if (store) {
  store.commit('set', props.count);
}

const productsCount = computed(() => store.state.productsCount);

</script>

<template>
      <a class="colorcounter" href="/carrito">{{ productsCount }}</a>
</template>

