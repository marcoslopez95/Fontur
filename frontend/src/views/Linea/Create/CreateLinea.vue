<template>
    <div>
        <div>
            <h2 class="text-xl text-center">Crear Línea</h2>
            <h3 class="text-sm text-center"></h3>
        </div>

        <div>
            <div class="p-[25px] flex gap-[25px] text-center">
                <div>
                    <div>
                        <label class="" for="plate">Nombre</label>
                    </div>
                    <div>
                        <input
                            v-model="formulario.name"
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

                <div class="w-[250px]">
                    <div>
                        <label class="" for="control">RIF</label>
                    </div>
                    <div>
                        <input
                            id="control"
                            v-model="formulario.rif"
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
                        <label class="" for="control">Municipio</label>
                    </div>
                    <div>
                        <select
                            v-model="formulario.municipality_id"
                            class="
                                w-[150px]
                                text-left
                                bg-slate-200
                                rounded
                                hover:ring-blue-300
                            "
                        >
                            <option
                                v-for="(municipality, j) in municipalities"
                                :key="j"
                                :value="municipality.id"
                            >
                                {{ municipality.nombre }}
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
let id = ref(0);

onBeforeMount(() => {
    getMunicipalities();
});

onMounted(() => {
    if (route.params.id) {
        id.value = route.params.id;
        getLine(id.value);
    }
});

let municipalities = ref([
    {
        id: "",
        nombre: "Seleccione...",
    },
]);

let formulario = ref({
    name: "",
    rif: "",
    municipality_id: "",
});

let items = ["nombre", "rif", "municipality_id"];

function validarForm(): boolean {
    let nombre = formulario.value.name;
    let rif = formulario.value.rif;
    let municipio = formulario.value.municipality_id;

    return nombre !== "" && rif !== "" && municipio !== "";
}

function getLine(id) {
    axios
        .get(`lines/${id}`)
        .then((res) => {
            let data = res.data.data;
            formulario.value = data;
        })
        .catch((err) => {});
}

function getMunicipalities() {
    let params = {
        state : 'táchira'
    }
    axios
        .get(`municipalities`,{params})
        .then((res) => {
            let data = res.data;
            console.log('mun',data);
            
            data.forEach((element) => {
                municipalities.value.push({
                    nombre: element.nombre,
                    id: element.id,
                });
            });
        })
        .catch((err) => {});
}

function guardar() {
    if (id.value !== 0) {
        axios.put(`lines/${id.value}`, formulario.value).then((resp) => {
            router.push({ name: "linea" });
        });
    } else {
        axios.post("lines", formulario.value).then((resp) => {
            router.push({ name: "linea" });
        });
    }
}

onUpdated(() => validarForm());
</script>

<style>
</style>