import axios, { V1_BASE } from '@/api/config.js'

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