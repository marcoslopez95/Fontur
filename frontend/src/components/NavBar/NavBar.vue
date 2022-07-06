<template src="./NavBar.html">
  
</template>

<script setup lang="ts">
import { TabGroup, TabList, Tab, TabPanels, TabPanel, DialogPanel, DialogTitle } from '@headlessui/vue'
import {onBeforeMount, onMounted} from 'vue'
import { ref } from 'vue'
import {useRoute} from 'vue-router'

let menuActive = ref(0)

const categories = ref([
    {
        item: 'Vehículos',
        to: 'Vehiculo',
        name: "Vehiculo"
    },
    {
        item: 'Supervisiones',
        to: 'Supervision',
        name: 'Supervision'
    },
    {
        item: 'Supervisores',
        to: 'Supervisor',
        name: 'Supervisor'
    },
    {
        item: 'Líneas',
        to: 'linea',
        name: 'linea'
    },
])
 
let hola = ()=>console.log('hola')

let indexActive = () => {
    let path = useRoute().name
    console.log('path',path); 
    
    menuActive.value = categories.value.findIndex(item => item.name === path);
    console.log('menuActive',menuActive.value);
}

onBeforeMount(
    ()=>{
        indexActive()
    }
)
onMounted(
    () => {
        indexActive()
    }
)
</script>

<style>

</style>