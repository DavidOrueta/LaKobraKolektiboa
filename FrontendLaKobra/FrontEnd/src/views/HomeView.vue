<script setup>
import wpp from '@/assets/wpp.jpg'
</script>

<template>
  <!-- BACKGROUND -->
  <div
    class="fixed inset-0 bg-cover bg-center -z-10"
    :style="{ backgroundImage: `url(${wpp})` }"
  ></div>
</template>