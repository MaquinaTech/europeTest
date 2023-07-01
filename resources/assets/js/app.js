import Vue from 'vue';
import router from './router';

// Importa tus componentes de Vue que usarás en la aplicación
import ListDog from './components/ListDog.vue';
import EditDog from './components/EditDog.vue';

Vue.component('listdog', ListDog);
Vue.component('editdog', EditDog);

const app = new Vue({
  el: '#app',
  router
});
