 <template>
    <div>
        <h2 class="text-xl font-bold text-center text-gray-900">
            Filtro de Supervisiones
        </h2>

        <div class="mx-[10%] px-[5px] my-[25px]">
            <div class="flex h-[25px] gap-[5px] justify-center my-[15px]">
                <div class="w-[90px]">
                    <label for="fecha_ini">Fecha inicio</label>
                </div>
                <div>
                    <input
                        class="
                            w-[200px]
                            ml-[5px]
                            px-[15px]
                            bg-slate-200
                            rounded
                            hover:ring-blue-300
                        "
                        type="date"
                        v-model="form.fecha_ini"
                        id="fecha_ini"
                    />
                </div>
            </div>
            <div class="flex h-[25px] gap-[5px] justify-center my-[15px]">
                <div class="w-[90px]">
                    <label for="fecha_fin">Fecha fin</label>
                </div>
                <div>
                    <input
                        v-model="form.fecha_fin"
                        class="
                            w-[200px]
                            ml-[5px]
                            px-[15px]
                            bg-slate-200
                            rounded
                            hover:ring-blue-300
                        "
                        type="date"
                        id="fecha_fin"
                    />
                </div>
            </div>
            <div class="flex h-[25px] gap-[5px] justify-center my-[15px]">
                <div class="w-[90px]">
                    <label for="municipality">Municipio</label>
                </div>
                <div class="w-[200px]">
                    <v-select
                        v-model="form.municipality_id"
                        class="w-[200px]"
                        id="municipality"
                        :options="municipalities"
                        @search="SearchMunicipality"
                        label="nombre"
                        :reduce="item => item.id"
                    >
                        <template #no-options>
                            Buscar municipio...
                        </template>
                    </v-select>
                    <!-- <SearchIcon
                        class="hover:cursor-pointer hover:stroke-blue-300 my-[3px]"
                        @click="SearchMunicipality"
                    /> -->
                </div>
            </div>
            <div class="flex h-[25px] gap-[5px] justify-center my-[15px]">
                <div class="w-[90px]">
                    <label for="municipality">Líneas</label>
                </div>
                <div class="w-[200px]">
                    <v-select
                        v-model="form.line"
                        class="w-[200px]"
                        id="municipality"
                        :options="lines"
                        @search="SearchLines"
                        label="name"
                        :reduce="item => item.id"
                    >
                        <template #no-options>
                            Buscar líneas...
                        </template>
                    </v-select>
                    <!-- <SearchIcon
                        class="hover:cursor-pointer hover:stroke-blue-300 my-[3px]"
                        @click="SearchMunicipality"
                    /> -->
                </div>
            </div>
            <div class="flex h-[25px] gap-[5px] justify-center my-[15px]">
                <div class="w-[90px]">
                    <label for="municipality">Supervisor</label>
                </div>
                <div class="w-[200px]">
                    <v-select
                        v-model="form.supervisor_id"
                        class="w-[200px]"
                        id="municipality"
                        :options="supervisors"
                        @search="SearchSupervisors"
                        label="full_name"
                        :reduce="item => item.id"
                    >
                        <template #no-options>
                            Buscar supervisores...
                        </template>
                    </v-select>
                    <!-- <SearchIcon
                        class="hover:cursor-pointer hover:stroke-blue-300 my-[3px]"
                        @click="SearchMunicipality"
                    /> -->
                </div>
            </div>
        </div>

        <div class="text-center">
            <button
                class="
                    bg-blue-600
                    text-white
                    px-4
                    py-2
                    text-sm
                    uppercase
                    tracking-wide
                    font-bold
                    rounded-lg
                "
                @click="emit('filtrar',form)"
            >
                Filtrar
            </button>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref } from "@vue/reactivity";
import axios from "axios";
import VSelect from "vue-select";
import SearchIcon from "../../components/Icons/SearchIcon.vue";
import { _ } from "lodash";
//const emit = defineEmits(["close",'filtrar']);
const emit = defineEmits<{
  (e: 'filtrar', value: object): void
}>()

const form = ref({
    fecha_ini: "",
    fecha_fin: "",
    municipality_id: "",
    line: "",
    supervisor_id: ''
});

const municipalities = ref([]);
let SearchMunicipality = (search : string, loading) => {
    if(search.length){
        municipalities.value = []
        loading(true)
        search1(loading,search)
    }
};
let search1 = _.debounce((loading, search) => {
    let params = {
        state: "táchira",
        nombre: search,
    };
    axios.get("municipalities", { params }).then((res) => {
        let data = res.data
        console.log(data);
        
        data.forEach((item) => {
            municipalities.value.push({
                id: item.id,
                nombre: item.nombre
                })
        })
        loading(false)
    });
}, 350);

const lines = ref([]);
let SearchLines = (search : string, loading) => {
    if(search.length){
        lines.value = []
        loading(true)
        search2(loading,search)
    }
};
let search2 = _.debounce((loading, search) => {
    let params = {
        name: search,
    };
    axios.get("lines", { params }).then((res) => {
        let data = res.data.data
        console.log(data);
        
        data.forEach((item) => {
            lines.value.push({
                id: item.id,
                name: item.name
                })
        })
        loading(false)
    });
}, 350);

const supervisors = ref([]);
let SearchSupervisors = (search : string, loading) => {
    if(search.length){
        supervisors.value = []
        loading(true)
        search3(loading,search)
    }
};
let search3 = _.debounce((loading, search) => {
    let params
    if(form.value.municipality_id == ''){
        params = {
            supervision: search,
        };
    }else{
        params = {
            supervision: search,
            regional: 1
        };
    }
    console.log(params);
    
    axios.get("supervisors", { params })
    .then((res) => {
        let data = res.data.data
        console.log(data);
        
        data.forEach((item) => {
            supervisors.value.push({
                id: item.id,
                full_name: item.first_name + ' ' + item.last_name
                })
        })
        loading(false)
    });
}, 350);


</script>

<style>
</style>