<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const emit = defineEmits(['volver', 'logout'])

const vendedores = ref([])
const reglas = ref([])
const resumen = ref([])
const fechaInicio = ref('')
const fechaFin = ref('')
const calculado = ref(false)
const mensaje = ref('')

async function cargar() {
  try {
    const res = await axios.get('/api/comisiones/iniciales')
    vendedores.value = res.data.vendedores
    reglas.value = res.data.reglas
  } catch (e) {
    if (e.response && e.response.status === 401) {
      emit('logout')
    }
  }
}

onMounted(cargar)

async function calcular() {
  mensaje.value = ''
  try {
    const res = await axios.post('/api/comisiones/calcular', {
      fecha_inicio: fechaInicio.value,
      fecha_fin: fechaFin.value,
    })
    resumen.value = res.data.resumen
    calculado.value = true
  } catch (e) {
    calculado.value = false
    mensaje.value = 'Revisa las fechas (la fecha fin no puede ser menor a la de inicio)'
  }
}
</script>

<template>
  <div class="contenedor">
    <div class="encabezado">
      <h2>Comisiones</h2>
      <button class="secundario" @click="emit('volver')">Volver a productos</button>
    </div>

    <div class="tarjeta">
      <h3>Calcular comisiones</h3>
      <div class="formulario">
        <input v-model="fechaInicio" type="date" />
        <input v-model="fechaFin" type="date" />
        <button @click="calcular">Calcular</button>
      </div>
      <p class="mensaje">{{ mensaje }}</p>

      <table v-if="calculado">
        <thead>
          <tr><th>Vendedor</th><th>Comisión total</th></tr>
        </thead>
        <tbody>
          <tr v-for="r in resumen" :key="r.vendedor">
            <td>{{ r.vendedor }}</td>
            <td>${{ Number(r.total_comision).toFixed(2) }}</td>
          </tr>
        </tbody>
      </table>
      <p v-if="calculado && resumen.length === 0">No hay ventas en ese rango</p>
    </div>

    <div class="tarjeta">
      <h3>Vendedores</h3>
      <table>
        <thead>
          <tr><th>Nombre</th><th>Email</th></tr>
        </thead>
        <tbody>
          <tr v-for="v in vendedores" :key="v.id">
            <td>{{ v.nombre }}</td>
            <td>{{ v.email }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="tarjeta">
      <h3>Reglas de comisión</h3>
      <table>
        <thead>
          <tr><th>Desde (monto)</th><th>Porcentaje</th></tr>
        </thead>
        <tbody>
          <tr v-for="r in reglas" :key="r.id">
            <td>${{ Number(r.umbral_monto).toFixed(2) }}</td>
            <td>{{ (Number(r.porcentaje) * 100).toFixed(0) }}%</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
