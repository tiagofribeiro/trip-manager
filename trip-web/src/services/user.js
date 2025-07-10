import api from './api'

// TODO: processar resultado antes de retornar na view?

export const login = (credentials) => {
  return api.post('/login', credentials)
}

export const register = (data) => {
  return api.post('/register', data)
}

export const getProfile = () => {
  return api.get('/profile', {
    headers: {
      Authorization: `Bearer ${localStorage.getItem('token')}`
    }
  })
}

export const refreshToken = () => {
  return api.post('/refresh-token', {}, {
    headers: {
      Authorization: `Bearer ${localStorage.getItem('token')}`
    }
  })
}
