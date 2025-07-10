<script setup>
import { ref } from 'vue';
import { login } from '@/services/user'
import { useRouter } from 'vue-router';

const email = ref('')
const password = ref('')
const error = ref('')
const router = useRouter()

const handleLogin = async () => {
  error.value = null

  try {
    const response = await login({
      email: email.value,
      password: password.value
    })

    if (response.data.token) {
      localStorage.setItem('token', response.data.token)
      router.push('/dashboard')
    } else {
      error.value = 'Não foi possível realizar o login. Cheque suas credenciais.'
    }
  } catch (err) {
    error.value = err.response?.data?.error || 'Erro ao fazer login'
  }
}

</script>

<template>
  <main class="login-container">
    <h1>Login</h1>
    <form @submit.prevent="handleLogin">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="email" required />
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" v-model="password" required />
      </div>
      <button type="submit">Entrar</button>
    </form>

    <p v-if="error" class="error">{{ error }}</p>
  </main>
</template>

<style scoped>
.login-container {
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
  height: 40px;
}

.error {
  color: red;
  margin-top: 1rem;
}

</style>