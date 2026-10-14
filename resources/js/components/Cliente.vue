<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const emit = defineEmits(['logout'])
const productos = ref([])

async function cargar() {
  try {
    const res = await axios.get('/api/products')
    productos.value = res.data
  } catch (e) {
    if (e.response && e.response.status === 401) {
      emit('logout')
    }
  }
}

onMounted(cargar)

async function salir() {
  await axios.post('/auth/logout')
  emit('logout')
}
</script>

<template>
  <div class="contenedor">
    <div class="encabezado">
      <h2>Catálogo de productos</h2>
      <button class="secundario" @click="salir">Cerrar sesión</button>
    </div>

    <div class="tarjeta">
      <table>
        <thead>
          <tr><th>Nombre</th><th>Precio</th></tr>
        </thead>
        <tbody>
          <tr v-for="p in productos" :key="p.id">
            <td>{{ p.name }}</td>
            <td>{{ p.price }}</td>
          </tr>
        </tbody>
      </table>
      <p v-if="productos.length === 0">No hay productos todavía</p>
    </div>
  </div>
</template>
