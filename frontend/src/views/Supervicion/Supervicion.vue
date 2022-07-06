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
                    <a target="_blank" :href="dowload">
                        <ButtonCustom
                            title="Descargar"
                            class="
                                ml-[80px]
                                h-[40px]
                                bg-green-700
                                hover:bg-green-400
                            "
                            
                        >
                            <DownloadIcon />
                        </ButtonCustom>
                    </a>
                    <a target="_blank">
                        <ButtonCustom
                            title="Descargar"
                            class="
                                ml-[80px]
                                h-[40px]
                                bg-green-700
                                hover:bg-green-400
                            "
                            @click="descargar"
                        >
                            <filter-icon />
                        </ButtonCustom>
                    </a>
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

//const eventStore = inject<boolean>(StoreSupervision,false)
const router = useRouter();
let items = ref([]);
let loading = ref(false);
let dowload = import.meta.env.VITE_API+'/report/vehicles'
function CreateSupervision() {
    router.push({ name: "supervision-create" });
}

function descargar() {
    axios.get('report/vehicles')
}

function getIndex() {
    axios
        .get("supervisions")
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

onMounted(() => {
    getIndex();
});
</script>

<style src="./Supervicion.css">
</style>