import {useRoute} from 'vue-router'
import VehiculoVue from '../Vehiculo/Vehiculo.vue'
import SupervicionVue from '../Supervicion/Supervicion.vue'

const route = useRoute()
let isHome = false

if(route.name === 'Home')
    isHome = true

export {
    isHome
}
