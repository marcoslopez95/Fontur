<template>
    <div>
        <h2 class="text-xl font-bold text-center text-gray-900 mb-[15px]">
            Descargar Reporte
        </h2>

        <div class="text-center">
            <a
                target="_blank"
                v-for="(item, i) in download_types"
                :key="i"
                :href="url_base+'type_report='+item.url"
            >
                <ButtonCustom
                    title="Descargar"
                    class="h-[40px] w-[150px] bg-green-700 hover:bg-green-400"
                >
                    {{item.name}}
                </ButtonCustom>
            </a>
        </div>
    </div>
</template>

<script lang="ts" setup>
import ButtonCustom from "../../components/ButtonCustom.vue";

const props = defineProps<{
    url_base: String;
}>();

const download_types = [
    {
        url: "General",
        name: "General",
    },
    {
        url: "Supervisor",
        name: "Por Supervisor",
    },
    {
        url: "Linea",
        name: "Por Línea",
    },
];
</script>

<style>
</style>