import { createRouter, createWebHistory } from 'vue-router';

//Routes
//import Home from '../views/Home.vue'
import About from '../views/About.vue'
import NotFound from '../views/NotFound.vue'
import Inicio from '../views/Inicio/Inicio.vue'

const routes = [
  {
    path: '/',
    meta: { title: 'Home' },
    component: Inicio,
  },
  {
    path: '/about',
    meta: { title: 'About' },
    component: About,
    // example of route level code-splitting
    // this generates a separate chunk (About.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    // component: () => import('../views/About.vue')
  },
  {
    path: '/:page',
    component: NotFound,
  },
];

export const Router = createRouter({
  scrollBehavior: () => ({ left: 0, top: 0 }),
  history: createWebHistory(),
  routes,
});
