import Vue from 'vue';
import router from './router';

// Importa tus componentes de Vue que usarás en la aplicación
import ListDog from './components/ListDog.vue';
import EditDog from './components/EditDog.vue';
import CreateDog from './components/CreateDog.vue';

Vue.component('listdog', ListDog);
Vue.component('editdog', EditDog);
Vue.component('createdog', CreateDog);

const app = new Vue({
  el: '#app',
  router
});
