<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import Login from './components/Login.vue'
import Productos from './components/Productos.vue'

const logueado = ref(false)
const cargando = ref(true)

// al abrir la página, pregunta al backend si ya hay sesión
onMounted(async () => {
  const res = await axios.get('/auth/me')
  logueado.value = res.data.logueado
  cargando.value = false
})
</script>

<template>
  <p v-if="cargando">Cargando...</p>
  <Login v-else-if="!logueado" @login="logueado = true" />
  <Productos v-else @logout="logueado = false" />
</template>