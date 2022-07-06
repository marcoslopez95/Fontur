<template>
    <button
        class="
            px-3
            border-black
            bg-red-600
            mx-1
            h-[25px]
            rounded-[25px]
            text-white
            hover:bg-blue-300
        "
        :class="[width]"
    >
  <slot></slot>
      
    </button>
</template>

<script lang="ts">
export default {
    props:{
    width:{type: String, default:'w-[50px]'}
    },
    data() {
        return {
           
        };
    },
};
</script>

<style>
</style>