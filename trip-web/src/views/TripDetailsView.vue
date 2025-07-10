<script setup>
import { onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { getOneTrip } from '@/services/trip'

const route = useRoute()
const tripId = route.params.id
const trip = ref(null)
const loading = ref(true)
const error = ref(null)
const router = useRouter()

const status = {
    pending: 'Pendente',
    approved: 'Aprovada',
    rejected: 'Cancelada'
}

const goBack = () => {
    router.back()
}

onMounted(async () => {
    try {
        const response = await getOneTrip(tripId)

        trip.value = response.data
    } catch (e) {
        error.value = 'Erro ao carregar detalhes da viagem.'
    } finally {
        loading.value = false
    }
})

</script>

<template>
    <div v-if="loading" class="loading">Carregando...</div>
    <div v-else-if="error" class="error">{{ error }}</div>
    <div v-else class="trip-details">
        <h2>Detalhes da Viagem para {{ trip.destination }}</h2>
        <p>Solicitante: {{ trip.user.name }}</p>
        <p>Email do solicitante: {{ trip.user.email }}</p>
        <p>Data de partida: {{ trip.departure_date }}</p>
        <p>Data de retorno: {{ trip.return_date || 'Não informada' }}</p>
        <p>Status: {{ status[trip.status] }}</p>

        <button @click="() => router.back()" class="back-button">← Voltar</button>
    </div>
</template>

<style scoped>
.trip-details {
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

.loading,
.error {
    text-align: center;
    margin-top: 2rem;
    font-size: 1.2rem;
    color: #666;
}

button {
  margin-top: 1.5rem;
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 8px;
  background-color: #999999;
  color: white;
  font-size: 1rem;
  cursor: pointer;
  transition: background-color 0.2s ease;
}

button:hover {
  background-color: #dadada;
}
</style>
