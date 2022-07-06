<template>
    <div>
        <div class="mx-[15px] flex mb-[15px]">
            <div class="w-[70px]">
                <label class="mr-[25px]" for="plate">Placa</label>
            </div>
            <div class="flex" @keypress.enter="filtrar">
                <input
                    v-model="buscar"
                    id="plate"
                    type="text"
                    class="
                        w-[150px]
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
            <div class="flex mx-[50px] my-auto">
                    <div class="mr-[15px]">
                        <label class="" for="control">Línea</label>
                    </div>
                    <div>
                        <select
                            v-model="line_id"
                            class="
                                w-[150px]
                                text-left
                                bg-slate-200
                                rounded
                                hover:ring-blue-300
                            "
                        >
                            <option
                                v-for="(line, l) in lines"
                                :key="l"
                                :value="line.id"
                            >
                                {{ line.nombre }}
                            </option>
                        </select>
                    </div>
                </div>
        </div>

        <div class="">
            <div class="mx-auto overflow-y-auto border h-[200px]">
                <div class="border-b-2">
                    <div class="flex">
                        <div
                            v-for="(header, i) in headers_vehicle"
                            :key="i"
                            class="w-[250px] text-center font-bold"
                        >
                            {{ header.text }}
                        </div>
                    </div>
                </div>
                <div>
                    <div
                        v-for="(vehiculo, i) in vehiculos"
                        :key="i"
                        class="flex text-center hover:bg-gray-100"
                    >
                        <div
                            v-for="(head, j) in headers_vehicle"
                            :key="j"
                            class="w-[250px]"
                        >
                            <span v-if="head.value !== 'select'">{{
                                vehiculo[head.value]
                            }}</span>
                            <input
                                v-else
                                type="checkbox"
                                class="text-lg"
                                :name="vehiculo.id"
                                :value="vehiculo.id"
                                v-model="form.selecteds"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="text-center mt-3">
                <ButtonCustom
                    class="
                        w-[90px]
                        text-lg
                        h-[40px]
                        bg-blue-500
                        hover:bg-blue-800
                    "
                    @click="guardar"
                >
                    Guardar
                </ButtonCustom>
            </div>
        </div>
        <!-- <div class="mx-[15px] flex">
            <div class="w-[110px]">
                <label class="mr-[25px]" for="obs">Observación</label>
            </div>
            <div class="flex">
                <input
                    id="obs"
                    value="asd"
                    type="text"
                    class="
                        ml-[5px]
                        px-[15px]
                        bg-slate-200
                        rounded
                        hover:ring-blue-300
                    "
                />
            </div>
        </div> -->
    </div>
</template>

<script lang="ts" setup>
import SearchIcon from "../../../components/Icons/SearchIcon.vue";
import { ref, onMounted, onUpdated } from "vue";
import axios from "axios";
import ButtonCustom from "../../../components/ButtonCustom.vue";

const props = defineProps<{
    municipality_id: string | null
}>()


const headers_vehicle = ref([
    {
        text: "Placa",
        value: "placa",
    },
    {
        text: "Tipo de Combustible",
        value: "type_fuel",
    },
    {
        text: "Control",
        value: "control",
    },
    {
        text: "Seleccionar",
        value: "select",
    },
]);

let vehiculos = ref([]);
let original = ref([]);
let line_id = ref('')

const lines = ref([{
    id: '',
    nombre: 'Todas'
}])
let form = ref({
    selecteds: [],
});
let charging = ref(true);
let buscar = ref("");
const emit = defineEmits(["loading",'guardar']);

function guardar(){
    emit('guardar',form.value.selecteds)
}

onMounted(() => {
    axios.get("/vehicles").then((response) => {
        let data: array = response.data.data;
        console.log("data", data);

        data.forEach((vehiculo: object) => {
            vehiculo.select = false;
        });

        emit("loading");
        charging.value = false;
        vehiculos.value = original.value = data;
    });
});


function getLines(){
   let params = {
        line_id: line_id.value,
    };

    axios
        .get(`line`, { params })
        .then((res) => {
            let data = res.data.data;
            console.log("mun", data);

            data.forEach((element) => {
                lines.value.push({
                    nombre: element.name,
                    id: element.id,
                });
            });
        })
        .catch((err) => {});
}

function filtrar() {
     vehiculos.value = original.value 
    let filter = vehiculos.value.filter(
        (vehiculo) => vehiculo.placa.toLowerCase().includes(buscar.value.toLowerCase())
    );

    vehiculos.value = buscar.value === "" ? original.value : filter;
}
</script>

<style>
</style>