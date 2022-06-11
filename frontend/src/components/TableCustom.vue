<template>
    <div class="px-[24px]">
        <div class="mx-auto overflow-y-auto h-[350px]" :class="widthTable">
            <div class="border-b-2 border-b-black">
                <div class="flex">
                    <div
                        v-for="(header, i) in headers"
                        class="text-center font-bold w-[250px]"
                        :class="[
                            header.value != 'act' ? widthColumn : 'w-[250px]',
                        ]"
                        :key="i"
                    >
                        {{ header.text }}
                    </div>
                </div>
            </div>
            <div>
                <div
                    v-for="(item, j) in items"
                    :key="j"
                    class="text-center hover:bg-gray-200 flex"
                >
                    <div v-for="(key, k) in headers" :key="k" class="w-[250px]">
                        <span v-if="key.value == 'num'">{{ j + 1 }}</span>
                        <span v-if="key.value == 'act'">
                            <Actions
                                :routeEdit="routeEdit"
                                :id="item.id"
                                :urlDelete="urlDelete"
                            />
                        </span>
                        <span v-else>{{ item[key.value] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import {onBeforeMount,toRefs} from 'vue'
import Actions from './AccionesCustom.vue'
interface props{
    headers: Array<{}>,
    items: Array<{}>,
    widthTable: string,
    widthColumn: string,
    routeEdit: string | undefined | null,
    urlDelete: string | undefined | null,
}

const props = defineProps<props>();
const {headers} = toRefs(props)
onBeforeMount(
    () => {
        let bool: Boolean = false;
        
        headers.value.forEach(item => {
            if( item.value === 'act') bool = true
        })
        
        if(!bool){
headers.value.push({
        value:'act',
        text:'Acciones'
        })
        }
        
        
    })
    

</script>

<style>
</style>