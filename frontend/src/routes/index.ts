import { createRouter, createWebHistory } from 'vue-router';
//import HomeVue from '../views/Home.vue';
import IndexVue from '../views/Index/Index.vue';
import SupervicionCreate from '../views/Supervicion/Create/SupervisionCreate.vue';
import SupervicionVue from '../views/Supervicion/Supervicion.vue';
import CreateVehiculo from '../views/Vehiculo/Create/CreateVehiculo.vue';
import VehiculoVue from '../views/Vehiculo/Vehiculo.vue';
import SupervisorVue from '../views/Supervisor/Supervisor.vue';
import LineaVue from '../views/Linea/Linea.vue';
import CreateLinea from '../views/Linea/Create/CreateLinea.vue';
import CreateSupervisor from '../views/Supervisor/Create/CreateSupervisor.vue';

const Router = createRouter({
  scrollBehavior: () => ({ left: 0, top: 0 }),
  history: createWebHistory(),
  routes: [
    // Supervisiones
    {
      path: '/',
      meta: { title: 'Supervision' },
      name: 'Supervision',
      component: SupervicionVue,
    },
    {
      path: '/supervision/create',
      name: 'supervision-create',
      component: SupervicionCreate,
    },

    // Supervisores
    {
      path: '/supervisor',
      meta: { title: 'Supervisor' },
      name: 'Supervisor',
      component: SupervisorVue,
    },
    {
      path: '/supervisor/create',
      name: 'supervisor-create',
      component: CreateSupervisor,
    },
    {
      path: '/supervisor/edit/:id',
      name: 'supervisor-edit',
      component: CreateSupervisor,
    },

    //Lineas
    {
      path: '/linea',
      meta: { title: 'Linea' },
      name: 'linea',
      component: LineaVue,
    },
    {
      path: '/linea/create',
      name: 'linea-create',
      component: CreateLinea,
    },
    {
      path: '/linea/edit/:id',
      name: 'linea-edit',
      component: CreateLinea,
    },

    //Vehiculos
    {
      path: '/vehiculo',
      meta: { title: 'Vehiculo' },
      name: 'Vehiculo',
      component: VehiculoVue,
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