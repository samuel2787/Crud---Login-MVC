<script setup>
import { ref } from 'vue'
import axios from 'axios'

const emit = defineEmits(['login'])

const name = ref('')
const email = ref('')
const password = ref('')
const mensaje = ref('')

async function entrar() {
  try {
    await axios.post('/auth/login', { email: email.value, password: password.value })
    emit('login')
  } catch (e) {
    mensaje.value = 'Datos incorrectos'
  }
}

async function registrar() {
  try {
    await axios.post('/auth/register', {
      name: name.value,
      email: email.value,
      password: password.value,
    })
    mensaje.value = 'Usuario creado, ahora inicia sesión'
  } catch (e) {
    mensaje.value = 'No se pudo registrar (revisa los datos o el correo ya existe)'
  }
}
</script>

<template>
  <div class="tarjeta login">
    <h2>Iniciar sesión</h2>
    <input v-model="name" placeholder="Nombre (solo para registrarse)" />
    <input v-model="email" placeholder="Correo" />
    <input v-model="password" type="password" placeholder="Contraseña" />
    <button @click="entrar">Entrar</button>
    <button class="secundario" @click="registrar">Registrarme</button>
    <p class="mensaje">{{ mensaje }}</p>
  </div>
</template>