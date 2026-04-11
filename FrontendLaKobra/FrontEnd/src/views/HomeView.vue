<script setup>
import wpp from '@/assets/wpp.jpg'

// carrusel
import img1 from '@/assets/carrusel/1.jpg'
import img2 from '@/assets/carrusel/2.jpg'
import img3 from '@/assets/carrusel/3.jpg'

import { ref } from 'vue'

const images = [img1, img2, img3]
const current = ref(0)

const next = () => {
  current.value = (current.value + 1) % images.length
}

const prev = () => {
  current.value =
    (current.value - 1 + images.length) % images.length
}
</script>
<template>
  <div>
    <!-- Fondo -->
    <div
      class="fixed inset-0 bg-cover bg-center -z-10"
      :style="{ backgroundImage: `url(${wpp})` }"
    ></div>

    <!-- Carrusel -->
    <div class="flex items-center justify-center h-screen">
      <div class="flex items-center gap-4 bg-white/70 p-4 rounded-xl">

        <button @click="prev">⬅</button>

        <img
          :src="images[current]"
          class="w-[600px] h-[300px] object-cover rounded-lg"
        />

        <button @click="next">➡</button>

      </div>
    </div>
  </div>
</template>