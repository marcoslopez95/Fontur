<script setup lang="ts">
import NavBar from './components/NavBar/NavBar.vue'
</script>

<template>
<div class="block w-[90%] h-[600px] m-[10px] bg-white mx-auto rounded-lg">
  <NavBar />
<router-view class="p-[15px]"></router-view>
</div>
</template>

<style lang="postcss">
body{
    @apply bg-sky-400/30 
}</style>
