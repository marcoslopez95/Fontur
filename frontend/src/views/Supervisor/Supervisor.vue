<template >
    <div>
        <h1 class="text-4xl text-center">Supervisores</h1>

        <Loading :show="!loading" />
        <div v-if="loading">
            <ListCustom
                :headers="headers"
                :items="items"
                nombreBoton="Vehiculo"
                widthTable="w-[90%]"
                routeEdit="vehiculo-edit"
                urlDelete="vehicles"
                @click-create="CreateSupervision()"
            >
                <template #filtro>
                    <div class="flex h-[25px] ml-[80px]" @keypress.enter="filtrar">
                        <input
                            v-model="buscar"
                            id="plate"
                            placeholder="Buscar CI..."
                            type="text"
                            class="
                                w-[180px]
                                ml-[5px]
                                px-[15px]
                                bg-slate-200
                                rounded
                                hover:ring-blue-300
                            "
                        />
                        <SearchIcon
                            class="
                                ml-[-30px]
                                hover:cursor-pointer hover:stroke-blue-300
                            "
                            @click="filtrar"
                        />
                    </div>
                </template>
            </ListCustom>
        </div>
    </div>
</template>

<script setup lang="ts">
import ListCustom from "../../components/ListCustom/ListCustom.vue";
import { headers } from "./Supervisor";
import { useRouter } from "vue-router";
import { inject, watch, ref, onMounted } from "vue";
import axios from "axios";
import SearchIcon from "../../components/Icons/SearchIcon.vue";
import Loading from "../../components/Loading.vue";

//const eventStore = inject<boolean>(StoreSupervision,false)
const router = useRouter();
let items = ref([]);
let buscar = ref("");
let original = ref([]);
let loading = ref(false);

function CreateSupervision() {
    router.push({ name: "vehiculo-create" });
}

function filtrar() {
    items.value = original.value;
    console.log('buscar',buscar.value);
    let filter = items.value.filter((vehiculo) =>
        vehiculo.ci.toLowerCase().includes(buscar.value.toLowerCase())
    );
    console.log('items',filter);
    

    items.value = buscar.value === "" ? original.value : filter;
}

function getIndex() {
    axios
        .get("supervisors")
        .then((res) => {
            let data = res.data.data;
            items.value = original.value = data;
            loading.value = true;
        })
        .catch((err) => {
            let e = err.response.data;
            console.log("error", e);
        });
}

onMounted(() => {
    getIndex();
});
</script>

<style src="./Supervisor.css">
</style>