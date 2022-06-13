import { createRouter, createWebHistory } from 'vue-router';
//import HomeVue from '../views/Home.vue';
import IndexVue from '../views/Index/Index.vue';
import SupervicionCreate from '../views/Supervicion/Create/SupervisionCreate.vue';
import SupervicionVue from '../views/Supervicion/Supervicion.vue';
import CreateVehiculo from '../views/Vehiculo/Create/CreateVehiculo.vue';
import VehiculoVue from '../views/Vehiculo/Vehiculo.vue';

const Router = createRouter({
  scrollBehavior: () => ({ left: 0, top: 0 }),
  history: createWebHistory(),
  routes: [
    {
      path: '/',
      meta: { title: 'Supervision' },
      name: 'Supervision',
      component: SupervicionVue,
    },
    {
      path: '/vehiculo',
      meta: { title: 'Vehiculo' },
      name: 'Vehiculo',
      component: VehiculoVue,
    },
    {
      path: '/supervision/create',
      name: 'supervision-create',
      component: SupervicionCreate,
    },
    {
      path: '/vehiculo/create',
      name: 'vehiculo-create',
      component: CreateVehiculo,
    },
    {
      path: '/vehiculo/edit/:id',
      name: 'vehiculo-edit',
      component: CreateVehiculo,
    },
  ],
});

export {
  Router
} 