<template >
<div>
    <h1 class="text-4xl text-center">Supervisiones</h1>

    <ListCustom
        :headers="headers"
        :items="items"
        nombreBoton="Supervision"
        widthTable="w-[90%]"

        urlDelete="supervisions"
        @click-create="CreateSupervision()"
    />
    </div>
</template>

<script setup lang="ts">
import ListCustom from "../../components/ListCustom/ListCustom.vue";
import { headers } from "./Supervicion";
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
        .get('supervisions')
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

<style src="./Supervicion.css">
</style>