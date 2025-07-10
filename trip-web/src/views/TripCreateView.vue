<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { createTrip } from '@/services/trip'

const router = useRouter()

const destination = ref('')
const departureDate = ref('')
const returnDate = ref('')

const error = ref(null)
const loading = ref(false)

const submitTrip = async () => {
    if (!destination.value || !departureDate.value) {
        error.value = 'Preencha o destino e a data de partida.'

        return
    }

    loading.value = true
    error.value = null

    try {
        await createTrip({
            destination: destination.value,
            departure_date: departureDate.value,
            return_date: returnDate.value || null
        })

        router.push('/dashboard')
    } catch (e) {
        error.value = 'Erro ao criar viagem.'
    } finally {
        loading.value = false
    }
}

const goBack = () => {
    router.back()
}
</script>

<template>
    <div class="trip-details">
        <h2>Criar Nova Viagem</h2>

        <div v-if="error" class="error">{{ error }}</div>

        <form @submit.prevent="submitTrip">
            <p>
                <label>Destino:</label><br />
                <input type="text" v-model="destination" required />
            </p>

            <p>
                <label>Data de partida:</label><br />
                <input type="date" v-model="departureDate" required />
            </p>

            <p>
                <label>Data de retorno (opcional):</label><br />
                <input type="date" v-model="returnDate" />
            </p>

            <button type="submit" :disabled="loading">
                {{ loading ? 'Salvando...' : 'Salvar Viagem' }}
            </button>
            <button @click="goBack" class="back-button">← Voltar</button>
        </form>
    </div>
</template>

<style scoped>
.trip-details {
    width: 100%;
    max-width: 600px;
    margin: 2rem auto;
    padding: 2rem;
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    font-family: 'Arial', sans-serif;
}

h2 {
    margin-bottom: 1.5rem;
    color: #333;
    font-size: 1.75rem;
}

p {
    margin: 0.75rem 0;
    font-size: 1rem;
}

input {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 1rem;
}

button {
    margin-right: 1rem;
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

.back-button {
  background-color: #999999;
}

.back-button:hover {
  background-color:  #dadada;
}


.error {
    color: red;
    margin-bottom: 1rem;
}
</style>