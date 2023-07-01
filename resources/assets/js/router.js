import Vue from 'vue';
import VueRouter from 'vue-router';

// Importa tus componentes de Vue que usarás como vistas en las rutas
import EditDog from './components/EditDog.vue';
import ListDog from './components/ListDog.vue';
import CreateDog from './components/CreateDog.vue';

Vue.use(VueRouter);

const routes = [
  {
    path: '/perros/add',
    name: 'createdog',
    component: CreateDog
  },
  {
    path: '/perros',
    component: ListDog
  },
  {
    path: '/perros/:id',
    name: 'editdog',
    component: EditDog
  },
  
];

const router = new VueRouter({
  mode: 'history',
  routes
});

export default router;
