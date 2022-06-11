<template >
<div>
    <h1 class="text-4xl text-center">Vehiculo</h1>

    <ListCustom
        :headers="headers"
        :items="items"
        nombreBoton="Vehiculo"
        widthTable="w-[90%]"
        routeEdit="String"
        urlDelete="vehicles"
        @click-create="CreateSupervision()"
    />
    </div>
</template>

<script setup lang="ts">
import ListCustom from "../../components/ListCustom/ListCustom.vue";
import { headers } from "./Vehiculo";
import {useRouter} from 'vue-router'
import {inject,watch, ref, onMounted} from 'vue'
import axios from "axios";

//const eventStore = inject<boolean>(StoreSupervision,false)
const router = useRouter()
let items = ref([])

function CreateSupervision(){
    router.push({name: 'supervision-create'})
}

function getIndex(){
    axios
        .get('vehicles')
        .then(res => {
            let data = res.data.data
            items.value = data
        })
        .catch(err=>{
            let e = err.response.data
            console.log('error',e);
            
        })
}

onMounted(
    ()=> {
        getIndex()
    }
)

</script>

<style src="./Vehiculo.css">
</style>