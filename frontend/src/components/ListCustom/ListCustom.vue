<template src="./ListCustom.html"></template>

<script lang="ts" setup>
import TableCustom from "../TableCustom.vue";
import ButtomCustom from "../ButtonCustom.vue";
import { ref, toRefs, onMounted } from "vue";

interface props {
    interfaz:object,
    headers: Array,
    items: Array,
    widthTable?: String | undefined,
    widthColumn?: String | undefined,
    routeEdit: String | undefined | null,
    urlDelete: String | undefined | null,
    nombreBoton: String
}

//let nombreBoton= ref('hola')

const props = defineProps<props>();

let { widthTable, widthColumn } = toRefs(props);



</script>

<style>
</style>