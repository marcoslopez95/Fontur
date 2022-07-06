<template>
    <div>
        <div>
            <h2 class="text-xl text-center">Crear Supervisión</h2>
            <h3 class="text-sm text-center">
                Selecciona los vehículos que han trabajado
            </h3>
        </div>

        <Loading :show="!loading" />
        <div class="p-[15px]" v-show="loading">
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
                <div class="flex mx-[20px] my-auto">
                    <div class="mr-[15px]">
                        <label class="" for="control">Municipio</label>
                    </div>
                    <div>
                        <select
                            v-model="municipality_id"
                            class="
                                w-[150px]
                                text-left
                                bg-slate-200
                                rounded
                                hover:ring-blue-300
                            "
                            @change="getSupervisors"
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
                <div class="flex mx-[20px] my-auto">
                    <div class="mr-[15px]">
                        <label class="" for="control">Supervisor</label>
                    </div>
                    <div>
                        <select
                            v-model="supervisor_id"
                            class="
                                w-[150px]
                                text-left
                                bg-slate-200
                                rounded
                                hover:ring-blue-300
                            "
                        >
                            <option
                                v-for="(supervisor, l) in supervisors"
                                :key="l"
                                :value="supervisor.id"
                            >
                                {{ supervisor.nombre }}
                            </option>
                        </select>
                    </div>
                </div>
                
            </div>
            <SupervisionOne
                class="mt-[20px]"
                :municipality_id="municipality_id"
                @loading="load"
                @guardar="guardar"
            >
            </SupervisionOne>
        </div>
    </div>
</template>

<script lang="ts" setup>
import Loading from "../../../components/Loading.vue";
import ToggleCustom from "../../../components/ToggleCustom.vue";
import SupervisionOne from "./SupervisionOne.vue";
import SupervisionMany from "./SupervisionMany.vue";
import { ref, provide, onBeforeMount } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import type { InjectionKey } from "vue";

const StoreSupervision = Symbol() as InjectionKey<boolean>;
provide(StoreSupervision, true);

let municipality_id = ref("");
let supervisor_id = ref("");
let supervisors = ref([
    {
        id: "",
        nombre: "Seleccione...",
    },
]);
let municipalities = ref([
    {
        id: "",
        nombre: "Seleccione...",
    },
]);

function getMunicipalities() {
    let params = {
        state: "táchira",
    };
    axios
        .get(`municipalities`, { params })
        .then((res) => {
            let data = res.data;
            console.log("mun", data);

            data.forEach((element) => {
                municipalities.value.push({
                    nombre: element.nombre,
                    id: element.id,
                });
            });
        })
        .catch((err) => {});
}

function getSupervisors() {
    supervisors.value = [
        {
            id: "",
            nombre: "Seleccione...",
        },
    ];
    let params = {
        municipality_id: municipality_id.value,
    };
    axios
        .get(`supervisors`, { params })
        .then((res) => {
            let data = res.data.data;
            console.log("sup", data);

            data.forEach((element) => {
                console.log(element);

                supervisors.value.push({
                    nombre: element.first_name + " " + element.last_name,
                    id: element.id,
                });
            });
        })
        .catch((err) => {});
}

let type = ref("Supervisión Individual");
let enabled = ref(false);
let loading = ref(false);
let date = ref("");
let router = useRouter();
let load = () => (loading.value = true);

function cambio(value: boolean) {
    enabled.value = value;
    type.value =
        value === true ? "Supervisión Grupal" : "Supervisión Individual";
}

function guardar(selecteds: array) {
    let form = {
        vehiculos: selecteds,
        fecha: date.value,
    };

    axios
        .post("vehicles", form)
        .then((res) => {
            let data = res.data;
            console.log("res", data);
            router.push({ name: "Supervision" });
        })
        .catch((err) => {
            let e = err.response.data;
            console.log("err", e);
        });
}

onBeforeMount(() => {
    getMunicipalities();
});
</script>

