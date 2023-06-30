import Vue from 'vue';
import router from './router';

// Importa tus componentes de Vue que usarás en la aplicación
import Example from './components/Example.vue';
import EditDog from './components/EditDog.vue';

Vue.component('example', Example);
Vue.component('editdog', EditDog);

const app = new Vue({
  el: '#app',
  router
});
