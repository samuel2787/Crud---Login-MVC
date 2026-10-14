<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const emit = defineEmits(['logout', 'comisiones'])

const productos = ref([])
const name = ref('')
const price = ref('')
const editandoId = ref(null) // null = estamos creando

// READ: traer los productos
async function cargar() {
  try {
    const res = await axios.get('/api/products')
    productos.value = res.data
  } catch (e) {
    if (e.response && e.response.status === 401) {
      emit('logout') // si se perdió la sesión, vuelve al login
    }
  }
}

onMounted(cargar)

// CREATE o UPDATE
async function guardar() {
  const datos = { name: name.value, price: price.value }

  if (editandoId.value) {
    await axios.put('/api/products/' + editandoId.value, datos)
  } else {
    await axios.post('/api/products', datos)
  }

  name.value = ''
  price.value = ''
  editandoId.value = null
  cargar()
}

// prepara el formulario para editar
function editar(p) {
  editandoId.value = p.id
  name.value = p.name
  price.value = p.price
}

// DELETE
async function eliminar(id) {
  await axios.delete('/api/products/' + id)
  cargar()
}

async function salir() {
  await axios.post('/auth/logout')
  emit('logout')
}
</script>

<template>
  <div class="contenedor">
    <div class="encabezado">
      <h2>Panel de administrador</h2>
      <div>
        <button class="secundario" @click="emit('comisiones')">Ver comisiones</button>
        <button class="secundario" @click="salir">Cerrar sesión</button>
      </div>
    </div>

    <div class="tarjeta">
      <h3>{{ editandoId ? 'Editar producto' : 'Nuevo producto' }}</h3>
      <div class="formulario">
        <input v-model="name" placeholder="Nombre" />
        <input v-model="price" type="number" placeholder="Precio" />
        <button @click="guardar">{{ editandoId ? 'Actualizar' : 'Crear' }}</button>
      </div>
    </div>

    <div class="tarjeta">
      <table>
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="p in productos" :key="p.id">
            <td>{{ p.name }}</td>
            <td>{{ p.price }}</td>
            <td>
              <button class="pequeno" @click="editar(p)">Editar</button>
              <button class="pequeno rojo" @click="eliminar(p.id)">Eliminar</button>
            </td>
          </tr>
        </tbody>
      </table>
      <p v-if="productos.length === 0">No hay productos todavía</p>
    </div>
  </div>
</template>