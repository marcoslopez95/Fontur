<template>
    <div>
        <ButtonCustom
            @click="Editar"
            title="Editar"
            v-if="routeEdit !== undefined"
            class="bg-blue-600 hover:bg-blue-400"
        >
            <svg
                class="w-6 h-6"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                ></path>
            </svg>
        </ButtonCustom>
        <ButtonCustom @click="eliminar" title="Eliminar">
            <svg
                class="w-6 h-6"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                ></path></svg
        ></ButtonCustom>

        <slot></slot>
    </div>
</template>

<script setup lang="ts">
import ButtonCustom from "./ButtonCustom.vue";
import axios from "axios";
import { toRefs } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
interface props {
    routeEdit: string | undefined | null;
    id: number;
    urlDelete: string | undefined | null;
}

const props = defineProps<props>();

const { id, urlDelete, routeEdit } = toRefs(props);

function Editar() {
    console.log("edit", routeEdit.value);
    router.push({ name: routeEdit.value, params: { id: id.value } });
}

function eliminar() {
    let url = urlDelete.value + "/" + id.value;
    axios
        .delete(url)
        .then((response) => {
            console.log("eliminado ok");
            router.go(0);
        })
        .catch((error) => {
            console.log("mal eliminado");
        });
}
</script>

<style>
</style>