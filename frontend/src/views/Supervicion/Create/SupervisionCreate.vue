<template>
    <div>
        <div>
            <h2 class="text-xl text-center">Crear Supervisión</h2>
            <h3 class="text-sm text-center">Selecciona los vehículos que han trabajado</h3>
        </div>

<div class=" text-center">
<div v-show="!loading" class="loadingio-spinner-double-ring-tc3evlshl9p"><div class="ldio-uw8bm97k4no">
<div></div>
<div></div>
<div><div></div></div>
<div><div></div></div>
</div></div>
</div>
        <div class="p-[15px]" v-show="loading" >
            <div class="flex">
                <div class="mx-[15px] my-auto">
                    <label class="mr-[25px]" for="date">Fecha</label>
                    <input
                        id="date"
                        v-model="date"
                        type="date"
                        class="
                            ml-[5px]
                            px-[15px]
                            bg-slate-200
                            rounded
                            hover:ring-blue-300
                        "
                    />
                </div>
                <!-- <div class="flex" v-if="true == false">
                    <div class="mx-[25px] my-auto">
                        <label for="type_supervision">
                            {{ type }}
                        </label>
                    </div>

                    <ToggleCustom
                        class="pt-0 pb-0"
                        id="type_supervision"
                        @change="cambio"
                    />
                </div> -->
            </div>
            <SupervisionOne class="mt-[20px]" @loading="load" @guardar="guardar">
            </SupervisionOne>

            

        </div>
    </div>
</template>

<script lang="ts" setup>
import ToggleCustom from "../../../components/ToggleCustom.vue";
import SupervisionOne from "./SupervisionOne.vue";
import SupervisionMany from "./SupervisionMany.vue";
import { ref,provide } from "vue";
import {useRouter} from 'vue-router'
import axios from "axios";
import type { InjectionKey } from 'vue'

const StoreSupervision = Symbol() as InjectionKey<boolean>

provide(StoreSupervision, true)

let type = ref("Supervisión Individual");
let enabled = ref(false);
let loading = ref(false)
let date = ref('')
let router = useRouter()
let load = () => loading.value = true

function cambio(value: boolean) {
    enabled.value = value;
    type.value =
        value === true ? "Supervisión Grupal" : "Supervisión Individual";
}

function guardar(selecteds: array){
    let form = {
        vehiculos: selecteds,
        fecha: date.value
    }

    axios
        .post('vehicles',form)
        .then(res =>{
            let data = res.data
            console.log('res',data);
            router.push({name:'Supervision'})
        })
        .catch(err =>{
            let e = err.response.data
            console.log('err',e);
            
        })
}
</script>

<style type="text/css">
@keyframes ldio-uw8bm97k4no {
  0% { transform: rotate(0) }
  100% { transform: rotate(360deg) }
}
.ldio-uw8bm97k4no div { box-sizing: border-box!important }
.ldio-uw8bm97k4no > div {
  position: absolute;
  width: 144px;
  height: 144px;
  top: 28px;
  left: 28px;
  border-radius: 50%;
  border: 16px solid #000;
  border-color: #fef62a transparent #fef62a transparent;
  animation: ldio-uw8bm97k4no 1s linear infinite;
}

.ldio-uw8bm97k4no > div:nth-child(2), .ldio-uw8bm97k4no > div:nth-child(4) {
  width: 108px;
  height: 108px;
  top: 46px;
  left: 46px;
  animation: ldio-uw8bm97k4no 1s linear infinite reverse;
}
.ldio-uw8bm97k4no > div:nth-child(2) {
  border-color: transparent #140b02 transparent #140b02
}
.ldio-uw8bm97k4no > div:nth-child(3) { border-color: transparent }
.ldio-uw8bm97k4no > div:nth-child(3) div {
  position: absolute;
  width: 100%;
  height: 100%;
  transform: rotate(45deg);
}
.ldio-uw8bm97k4no > div:nth-child(3) div:before, .ldio-uw8bm97k4no > div:nth-child(3) div:after { 
  content: "";
  display: block;
  position: absolute;
  width: 16px;
  height: 16px;
  top: -16px;
  left: 48px;
  background: #fef62a;
  border-radius: 50%;
  box-shadow: 0 128px 0 0 #fef62a;
}
.ldio-uw8bm97k4no > div:nth-child(3) div:after {
  left: -16px;
  top: 48px;
  box-shadow: 128px 0 0 0 #fef62a;
}

.ldio-uw8bm97k4no > div:nth-child(4) { border-color: transparent; }
.ldio-uw8bm97k4no > div:nth-child(4) div {
  position: absolute;
  width: 100%;
  height: 100%;
  transform: rotate(45deg);
}
.ldio-uw8bm97k4no > div:nth-child(4) div:before, .ldio-uw8bm97k4no > div:nth-child(4) div:after {
  content: "";
  display: block;
  position: absolute;
  width: 16px;
  height: 16px;
  top: -16px;
  left: 30px;
  background: #140b02;
  border-radius: 50%;
  box-shadow: 0 92px 0 0 #140b02;
}
.ldio-uw8bm97k4no > div:nth-child(4) div:after {
  left: -16px;
  top: 30px;
  box-shadow: 92px 0 0 0 #140b02;
}
.loadingio-spinner-double-ring-tc3evlshl9p {
  width: 200px;
  height: 200px;
  display: inline-block;
  overflow: hidden;
  background: #ffffff;
}
.ldio-uw8bm97k4no {
  width: 100%;
  height: 100%;
  position: relative;
  transform: translateZ(0) scale(1);
  backface-visibility: hidden;
  transform-origin: 0 0; /* see note above */
}
.ldio-uw8bm97k4no div { box-sizing: content-box; }
/* generated by https://loading.io/ */
</style>