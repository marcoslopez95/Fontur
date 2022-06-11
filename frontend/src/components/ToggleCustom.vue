<template>
    <div class="py-16" @click="cambio()">
        <Switch
          
            v-model="enabled"
            :class="enabled ? 'bg-teal-400' : 'bg-teal-900'"
            class="
                relative
                inline-flex
                h-[38px]
                w-[74px]
                shrink-0
                cursor-pointer
                rounded-full
                border-2 border-transparent
                transition-colors
                duration-200
                ease-in-out
                focus:outline-none
                focus-visible:ring-2
                focus-visible:ring-white
                focus-visible:ring-opacity-75
            "
        >
            <span class="sr-only">Use setting</span>
            <span
                aria-hidden="true"
                :class="enabled ? 'translate-x-9' : 'translate-x-0'"
                class="
                    pointer-events-none
                    inline-block
                    h-[34px]
                    w-[34px]
                    transform
                    rounded-full
                    bg-white
                    shadow-lg
                    ring-0
                    transition
                    duration-200
                    ease-in-out
                "
            />
        </Switch>
    </div>
</template>

<script setup lang="ts">
import { ref, watch } from "vue";
import { Switch } from "@headlessui/vue";

const enabled = ref(false);
const emit = defineEmits(['change'])
function cambio(){
  emit('change',enabled.value)
  console.log('cambio',enabled.value);
  
}
</script>