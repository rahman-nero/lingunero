import axios from 'axios'

const API_BASE = import.meta.env.VITE_API_BASE_URL || 'http://localhost'

/** Base URL for API v1 endpoints */
export const V1_BASE = `${API_BASE}/api/v1`

axios.defaults.headers.common['Accept'] = 'application/json'
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

// Attach bearer token to every request if it exists in localStorage
axios.interceptors.request.use((config) => {
  const token = localStorage.getItem('auth_token')
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }
  return config
})


axios.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      localStorage.removeItem('auth_token')
      if (window.location.pathname !== '/login' && window.location.pathname !== '/register') {
        window.location.href = '/login'
      }
    }
    return Promise.reject(error)
  }
)

export default axios
