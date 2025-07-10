<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { register } from '@/services/user';

const name = ref('')
const email = ref('')
const password = ref('')
const error = ref('')
const success = ref('')
const router = useRouter()

const handleRegister = async () => {
  error.value = ''
  success.value = ''

  try {
    await register({
      name: name.value,
      email: email.value,
      password: password.value
    })

    success.value = 'Registro realizado com sucesso! Faça login.'

    // TODO: melhorar exibição de feedback?
    setTimeout(() => {
      router.push('/login')
    }, 1500)
  } catch (err) {
    error.value = err.response?.data?.message || 'Erro ao registrar'
  }
}
</script>

<template>
  <main class="register-container">
    <h1>Registrar</h1>
    <form @submit.prevent="handleRegister">
      <div class="form-group">
        <label for="name">Nome:</label>
        <input id="name" v-model="name" required />
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="email" required />
      </div>
      <div class="form-group">
        <label for="password">Senha:</label>
        <input type="password" id="password" v-model="password" required />
      </div>
      <button type="submit">Registrar</button>
    </form>

    <p v-if="error" class="error">{{ error }}</p>
    <p v-if="success" class="success">{{ success }}</p>
  </main>
</template>

<style scoped>
.register-container {
  max-width: 400px;
  margin: auto;
  padding: 2rem;
}

form {
  display: flex;
  flex-direction: column;
  margin: 1rem 0;
  gap: 1rem;
  align-items: center;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

button {
  width: 100%;
  margin-top: 1.5rem;
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 8px;
  background-color: rgb(0, 138, 92);
  color: white;
  font-size: 1rem;
  cursor: pointer;
  transition: background-color 0.2s ease;
}

button:hover {
  background-color: rgb(0, 197, 131);
}

.error {
  color: red;
  margin-top: 1rem;
}

.success {
  color: green;
  margin-top: 1rem;
}
</style>
