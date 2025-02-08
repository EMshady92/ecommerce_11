import {createStore} from 'vuex';
const store = createStore({
    state: {
      productsCount: 0
    },
    mutations: {
      increment(state) {
        state.productsCount++;
      },
      set(state, value) {
        state.productsCount = value;
      }
    }
  });
  export default store;
