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
            <SupervisionOne
                class="mt-[20px]"
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
import { ref, provide } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import type { InjectionKey } from "vue";

const StoreSupervision = Symbol() as InjectionKey<boolean>;

provide(StoreSupervision, true);

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
</script>

