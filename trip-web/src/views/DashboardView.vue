<script setup>
import { onMounted, ref } from 'vue'
import { useRouter, RouterLink } from 'vue-router'
import { getAllTrips, updateTripStatus, cancelTrip } from '@/services/trip'

// TODO: melhorar loading?

const trips = ref([])
const loading = ref(false)
const error = ref(null)
const router = useRouter()

onMounted(() => {
  const token = localStorage.getItem('token')
  if (!token) {
    router.push('/login')
  } else {
    fetchTrips()
  }
})

const fetchTrips = async () => {
  loading.value = true
  error.value = null

  try {
    const response = await getAllTrips()
    trips.value = response.data
  } catch (e) {
    error.value = 'Erro ao carregar viagens.'
  } finally {
    loading.value = false
  }
}

const changeStatus = async (tripId, newStatus) => {
  try {
    await updateTripStatus(tripId, newStatus)
    const trip = trips.value.find(t => t.id === tripId)

    if (trip) trip.status = newStatus
    alert('Status atualizado!')
  } catch (e) {
    alert('Erro ao atualizar status')
  }
}

const handleCancel = async (tripId) => {
  try {
    await cancelTrip(tripId)
    const trip = trips.value.find(t => t.id === tripId)

    if (trip) trip.status = 'rejected'
    alert('Viagem cancelada com sucesso')
  } catch (e) {
    alert('Erro ao cancelar a viagem')
  }
}

const logout = () => {
  localStorage.removeItem('token')
  router.push('/login')
}
</script>

<template>
  <main>
    <h1>Dashboard</h1>
    <div v-if="loading">Carregando...</div>
    <div v-if="error" class="error">{{ error }}</div>

    <table v-if="trips.length && !loading" class="trip-table">
      <thead>
        <tr>
          <th>Destino</th>
          <th>Data de Ida</th>
          <th>Data de Volta</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="trip in trips" :key="trip.id">
          <td>{{ trip.destination }}</td>
          <td>{{ new Date(trip.departure_date).toLocaleDateString() }}</td>
          <td>{{ trip.return_date ? new Date(trip.return_date).toLocaleDateString() : '-' }}</td>
          <td>
            <select v-model="trip.status" @change="changeStatus(trip.id, trip.status)">
              <option value="pending">Pendente</option>
              <option value="approved">Aprovada</option>
              <option value="rejected" disabled>Cancelada</option>
            </select>
          </td>
          <td>
            <RouterLink :to="{ name: 'trip-details', params: { id: trip.id } }">
              <button>Detalhes</button>
            </RouterLink>

            <button v-if="trip.status !== 'approved'" class="cancel-button" @click="handleCancel(trip.id)">
              Cancelar
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <p v-else>Nenhuma viagem cadastrada.</p>
    <RouterLink to="/create-trip">
      <button class="create-button">Solicitar Nova Viagem</button>
    </RouterLink>
    <button @click="logout" class="logout-button">Logout</button>
  </main>
</template>

<style scoped>
.trip-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
}

.trip-table th,
.trip-table td {
  padding: 0.75rem 1rem;
  border: 1px solid #ddd;
  text-align: left;
}

.trip-table th {
  background-color: #f4f4f4;
}

.trip-table select {
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
  border: 1px solid #ccc;
  background-color: white;
}

button {
  padding: 0.5rem 1rem;
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

.cancel-button {
  background-color: #d9534f;
  margin-left: 0.5rem;
}

.cancel-button:hover {
  background-color: #c9302c;
}

.logout-button {
  margin-left: 1rem;
  margin-top: 1.5rem;
  padding: 0.75rem 1.5rem;
  background-color: #999999;
  margin-bottom: 1rem;
}

.logout-button:hover {
  background-color: #dadada;
}

.create-button {
  margin-top: 1.5rem;
  padding: 0.75rem 1.5rem;
  background-color: rgb(0, 138, 92);
  margin-bottom: 1rem;
}

.create-button:hover {
  background-color: rgb(0, 197, 131);
}

.error {
  color: red;
  margin-top: 1rem;
}
</style>
