<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import Login from './components/Login.vue'
import Productos from './components/Productos.vue'
import Comisiones from './components/Comisiones.vue'
import Cliente from './components/Cliente.vue'

const logueado = ref(false)
const role = ref('')
const vista = ref('productos')
const cargando = ref(true)

async function revisarSesion() {
  const res = await axios.get('/auth/me')
  logueado.value = res.data.logueado
  role.value = res.data.role
  cargando.value = false
}

function salio() {
  logueado.value = false
  role.value = ''
  vista.value = 'productos'
}

onMounted(revisarSesion)
</script>

<template>
  <p v-if="cargando">Cargando...</p>
  <Login v-else-if="!logueado" @login="revisarSesion" />
  <Productos v-else-if="role === 'admin' && vista === 'productos'" @logout="salio" @comisiones="vista = 'comisiones'" />
  <Comisiones v-else-if="role === 'admin'" @volver="vista = 'productos'" @logout="salio" />
  <Cliente v-else @logout="salio" />
</template>