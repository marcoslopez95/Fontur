<template>
    <div>
        <div>
            <h2 class="text-xl text-center">Crear Vehículo</h2>
            <h3 class="text-sm text-center"></h3>
        </div>

        <div>
            <div class="p-[25px] flex gap-[25px] text-center">
                <div>
                    <div>
                        <label class="" for="plate">Placa</label>
                    </div>
                    <div>
                        <input
                            v-model="formulario.placa"
                            id="plate"
                            type="text"
                            class="
                                w-[150px]
                                px-[15px]
                                bg-slate-200
                                rounded
                                hover:ring-blue-300
                            "
                        />
                    </div>
                </div>

                <div class="w-[160px]">
                    <div>
                        <label class="" for="fuel">Tipo de Combustible</label>
                    </div>
                    <div>
                        <select
                            id="fuel"
                            v-model="formulario.type_fuel"
                            type="text"
                            class="
                                w-[150px]
                                text-center
                                bg-slate-200
                                rounded
                                hover:ring-blue-300
                            "
                        >
                            <option
                                v-for="(type, i) in types_fuel"
                                :key="i"
                                :value="type.value"
                            >
                                {{ type.text }}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="w-[250px]">
                    <div>
                        <label class="" for="control">Número de Control</label>
                    </div>
                    <div>
                        <input
                            id="control"
                            v-model="formulario.num_controller"
                            type="text"
                            class="
                                w-[150px]
                                px-[15px]
                                bg-slate-200
                                rounded
                                hover:ring-blue-300
                            "
                        />
                    </div>
                </div>

                 <div class="w-[250px]">
                    <div>
                        <label class="" for="control">Línea</label>
                    </div>
                    <div>
                        <select v-model="formulario.line_id"   class="
                                w-[150px]
                                text-center
                                bg-slate-200
                                rounded
                                hover:ring-blue-300
                            ">
                            <option v-for="(line,j) in lines" :key="j" :value="line.id">
                                {{line.name}} 
                            </option>
                        </select>
                    </div>
                </div>
            </div> 

            <div>
                <div class="text-center">
                    <ButtonCustom
                        class="w-[100px] hover:bg-blue-500"
                        :class="[
                            !validarForm() ? 'bg-blue-100' : 'bg-blue-800',
                        ]"
                        :disabled="!validarForm()"
                        @click="guardar"
                    >
                        Guardar
                    </ButtonCustom>
                </div>
            </div>
        </div>
        
    </div>
</template>

<script lang="ts" setup>
import Loading from "../../../components/Loading.vue";
import { ref, onUpdated, onMounted, onBeforeMount } from "vue";
import ButtonCustom from "../../../components/ButtonCustom.vue";
import axios from "axios";
import { useRouter, useRoute } from "vue-router";
const router = useRouter();
const route = useRoute();
let id = ref(0)
onBeforeMount(() =>{
getLines()
})
onMounted(() => {
    
    if(route.params.id){
        id.value = route.params.id;
        getVehicle(id.value)
    }
});

let lines = ref([
    {
        id: '',
        name: 'Seleccione...'
    }
])

let types_fuel = ref([
    {
        text: "Diesel",
        value: "Diesel",
    },
    {
        text: "Gasolina",
        value: "Gasolina",
    },
    {
        text: "Eléctrico",
        value: "Eléctrico",
    },
]);

let formulario = ref({
    num_controller: "",
    placa: "",
    type_fuel: "Gasolina",
    line_id: ''
});

let items = ["num_controller", "placa", "type_fuel",'line_id'];

function validarForm(): boolean {
    let control = formulario.value.num_controller
    let placa = formulario.value.placa
    let type = formulario.value.type_fuel
    let line = formulario.value.line_id

    return control !== "" && placa !== "" && type !== "" && line !== '';
}

function getVehicle(id) {
    axios
        .get(`vehicles/${id}`)
        .then((res) => {
            let data = res.data.data;
            formulario.value = data;
        })
        .catch((err) => {});
}

function getLines() {
    axios
        .get(`lines`)
        .then((res) => {
            let data = res.data.data;
            data.forEach(element => {
                lines.value.push({
                    name: element.name,
                    id: element.id
                })
            })
           // console.log('lines',lines);
            
        })
        .catch((err) => {});
}

function guardar() {
    if(id.value !== 0){
    axios.put(`vehicles/${id.value}`, formulario.value).then((resp) => {
        router.push({ name: "Vehiculo" });
    });    
    }else{
axios.post("vehicles", formulario.value).then((resp) => {
        router.push({ name: "Vehiculo" });
    });
    }
    
}

onUpdated(() => validarForm());
</script>

<style>
</style>