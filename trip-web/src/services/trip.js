import api from './api'

const authHeader = () => ({
  Authorization: `Bearer ${localStorage.getItem('token')}`
})

export const getAllTrips = (filters = {}) => {
  return api.get('/trips', {
    params: filters,
    headers: authHeader()
  })
}

export const getOneTrip = (id) => {
  return api.get(`/trips/${id}`, {
    headers: authHeader()
  })
}

export const createTrip = (data) => {
  return api.post('/trips', data, {
    headers: authHeader()
  })
}

export const updateTripStatus = (id, status) => {
  return api.put(`/trips/${id}`, { status }, {
    headers: authHeader()
  })
}

export const cancelTrip = (id) => {
  return api.delete(`/trips/${id}`, {
    headers: authHeader()
  })
}
