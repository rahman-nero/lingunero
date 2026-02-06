import axios from 'axios'

const API_BASE = import.meta.env.VITE_API_BASE_URL || 'http://localhost'
const V1_BASE = `${API_BASE}/api/v1`

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

// On 401 response, token is expired/invalid — remove it and redirect to login
axios.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      removeToken()
      if (window.location.pathname !== '/login' && window.location.pathname !== '/register') {
        window.location.href = '/login'
      }
    }
    return Promise.reject(error)
  }
)

/**
 * Save token to localStorage
 */
export const setToken = (token) => {
  localStorage.setItem('auth_token', token)
}

/**
 * Remove token from localStorage
 */
export const removeToken = () => {
  localStorage.removeItem('auth_token')
}

/**
 * Get token from localStorage
 */
export const getToken = () => {
  return localStorage.getItem('auth_token')
}

/**
 * Login user
 * @param {Object} credentials - { email, password, remember }
 */
export const login = async (credentials) => {
  return axios.post(`${V1_BASE}/login`, credentials)
}

/**
 * Register new user
 * @param {Object} userData - { name, email, password, password_confirmation }
 */
export const register = async (userData) => {
  return axios.post(`${V1_BASE}/register`, userData)
}

/**
 * Logout user
 */
export const logout = async () => {
  return axios.post(`${V1_BASE}/logout`)
}

/**
 * Get authenticated user
 */
export const getUser = async () => {
  return axios.get(`${V1_BASE}/user`)
}