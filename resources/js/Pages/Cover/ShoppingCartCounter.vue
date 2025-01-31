<template>
    <a class="colorcounter" href="/carrito">{{productsCount}}</a>
</template>

  <script>
  export default {
    props:["count"],
    created(){
      window.store.commit("set",this.count)
    },
    computed:{
      productsCount(){
        return window.store.state.productsCount;
      }
    }
  }
  </script>
