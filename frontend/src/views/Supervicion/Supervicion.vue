<template >
    <div>
        <h1 class="text-4xl text-center">Supervisiones</h1>

        <Loading :show="!loading" />
        <ListCustom
            v-if="loading"
            :headers="headers"
            :items="items"
            nombreBoton="Supervision"
            widthTable="w-[90%]"
            urlDelete="supervisions"
            @click-create="CreateSupervision()"
        >
            <template #filtro>
                <div>
                    <a target="_blank">
                        <ButtonCustom
                            title="Descargar"
                            class="
                                ml-[80px]
                                h-[40px]
                                bg-green-700
                                hover:bg-green-400
                            "
                            @click="showModalDescarga = true"
                        >
                            <DownloadIcon />
                        </ButtonCustom>
                    </a>
                    <CardModal :showing="showModalDescarga" @close="showModalDescarga = false">
                       <BotoneraDescarga :url_base="dowload"/>
                    </CardModal>
                    <!-- ------------------------------- -->
                    <a target="_blank">
                        <ButtonCustom
                            title="Descargar"
                            class="
                                ml-[80px]
                                h-[40px]
                                bg-green-700
                                hover:bg-green-400
                            "
                            @click="showModal = true"
                        >
                            <filter-icon />
                        </ButtonCustom>
                    </a>
                    <CardModal :showing="showModal" @close="showModal = false">
                       <filtro-supervicion @close="showModal = false" @filtrar="filtrar" />
                    </CardModal>
                </div>
            </template>
        </ListCustom>
    </div>
</template>

<script setup lang="ts">
import ListCustom from "../../components/ListCustom/ListCustom.vue";
import { headers } from "./Supervicion";
import { useRouter } from "vue-router";
import { inject, watch, ref, onMounted } from "vue";
import axios from "axios";
import Loading from "../../components/Loading.vue";
import ButtonCustom from "../../components/ButtonCustom.vue";
import DownloadIcon from "../../components/Icons/DownloadIcon.vue";
import FilterIcon from "../../components/Icons/FilterIcon.vue";
import CardModal from "../../components/CardModal.vue";
import FiltroSupervicion from "./FiltroSupervicion.vue";
import BotoneraDescarga from "./BotoneraDescarga.vue";

//const eventStore = inject<boolean>(StoreSupervision,false)
const router = useRouter();
let items = ref([]);
const showModal = ref(false);
const showModalDescarga = ref(false);
let loading = ref(false);
let dowload = ref(import.meta.env.VITE_API + "/report/vehicles");
const filtro = ref({
    fecha_ini: "",
    fecha_fin: "",
    municipality_id: "",
    line: "",
    supervisor_id: ''
})

function CreateSupervision() {
    router.push({ name: "supervision-create" });
}

function descargar(): void {
    axios.get("report/vehicles");
}

function getIndex(params = null): void {
    items.value = []
    axios
        .get("supervisions",{params})
        .then((res) => {
            let data = res.data.data;
            items.value = data;
            loading.value = true;
        })
        .catch((err) => {
            let e = err.response.data;
            console.log("error", e);
        });
}

let filtrar = (value) => {
    loading.value = false
    showModal.value = false
    filtro.value = value
    getIndex(value)
    crearRuta()
}
let crearRuta = () => {
    dowload.value = import.meta.env.VITE_API + "/report/supervisions?";

    for(let item in filtro.value){
        dowload.value += `${item}=${filtro.value[item]}&`
    }
}
onMounted(() => {
    getIndex();
    crearRuta()
});
</script>

<style src="./Supervicion.css">
</style>