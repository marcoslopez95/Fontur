<template>
    <div>
        <div>
            <h2 class="text-xl text-center">Crear Supervisor</h2>
            <h3 class="text-sm text-center"></h3>
        </div>

        <div>
            <div class="p-[25px] flex gap-[25px] text-center">
                <div>
                    <div>
                        <label class="" for="nombre">Nombre</label>
                    </div>
                    <div>
                        <input
                            v-model="formulario.first_name"
                            id="nombre"
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
                <div>
                    <div>
                        <label class="" for="apellido">Apellido</label>
                    </div>
                    <div>
                        <input
                            v-model="formulario.last_name"
                            id="apellido"
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
                <div>
                    <div>
                        <label class="" for="ci">CI</label>
                    </div>
                    <div>
                        <input
                            v-model="formulario.ci"
                            id="ci"
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
                        <label class="" for="fuel">Regional</label>
                    </div>
                    <div>
                        <select
                            id="fuel"
                            v-model="formulario.regional"
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
                                v-for="(type, i) in regional"
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
                        <label class="" for="control">Municipios</label>
                    </div>
                    <div>
                        <select v-model="formulario.municipality_id"   class="
                                w-[150px]
                                text-center
                                bg-slate-200
                                rounded
                                hover:ring-blue-300
                            ">
                            <option v-for="(line,j) in municipalities" :key="j" :value="line.id">
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
getMunicipalities()
})
onMounted(() => {
    
    if(route.params.id){
        id.value = route.params.id;
        getSupervisor(id.value)
    }
});

let municipalities = ref([
    {
        id: '',
        name: 'Seleccione...'
    }
])

let regional = [
    {
        text: "No",
        value: false,
    },
    {
        text: "Si",
        value: true,
    }
];

let formulario = ref({
    first_name: "",
    last_name: "",
    ci: "",
    regional: false,
    municipality_id: ''
});

let items = ["num_controller", "placa", "type_fuel",'line_id'];

function validarForm(): boolean {
    let control = formulario.value.first_name
    let placa = formulario.value.last_name
    let type = formulario.value.ci
    let line = formulario.value.regional
    let muni = formulario.value.municipality_id

    return control !== "" && placa !== "" && type !== "" && muni!== '';
}

function getSupervisor(id) {
    axios
        .get(`supervisors/${id}`)
        .then((res) => {
            let data = res.data.data;
            formulario.value = data;
            if(formulario.value.regional == 'No'){
                formulario.value.regional = false
            }else{
                formulario.value.regional = true
            }
        })
        .catch((err) => {});
}

function getMunicipalities() {
    axios
        .get(`municipalities?state=táchira`)
        .then((res) => {
            let data = res.data;
            data.forEach(element => {
                municipalities.value.push({
                    name: element.nombre,
                    id: element.id
                })
            })
           // console.log('lines',lines);
            
        })
        .catch((err) => {});
}

function guardar() {
    if(id.value !== 0){
    axios.put(`supervisors/${id.value}`, formulario.value).then((resp) => {
        router.push({ name: "Supervisor" });
    });    
    }else{
axios.post("supervisors", formulario.value).then((resp) => {
        router.push({ name: "Supervisor" });
    });
    }
    
}

onUpdated(() => validarForm());
</script>

<style>
</style>