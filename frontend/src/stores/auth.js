import { ref, computed } from 'vue'
import { defineStore } from 'pinia'
import * as authApi from '@/api/auth'
import {getUser} from "../api/auth.js";

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const loading = ref(false)
  const error = ref(null)

  const isAuthenticated = computed(() => user.value !== null)

  /**
   * Login user
   */
  const login = async (credentials) => {
    loading.value = true
    error.value = null

    try {
      const response = await authApi.login(credentials)
      const token = response.data?.token
      if (token) {
        authApi.setToken(token)
      }
      user.value = response.data?.user || response.data
      return { success: true }
    } catch (err) {
      error.value = err.response?.data?.message || 'Login failed. Please try again.'
      return { success: false, error: error.value, errors: err.response?.data?.errors }
    } finally {
      loading.value = false
    }
  }

  /**
   * Register new user
   */
  const register = async (userData) => {
    loading.value = true
    error.value = null

    try {
      const response = await authApi.register(userData)
      const token = response.data?.token
      if (token) {
        authApi.setToken(token)
      }
      user.value = response.data?.user || response.data
      return { success: true }
    } catch (err) {
      error.value = err.response?.data?.message || 'Registration failed. Please try again.'
      return { success: false, error: error.value, errors: err.response?.data?.errors }
    } finally {
      loading.value = false
    }
  }

  /**
   * Logout user
   */
  const logout = async () => {
    loading.value = true
    error.value = null

    try {
      await authApi.logout()
      authApi.removeToken()
      user.value = null
      return { success: true }
    } catch (err) {
      // Remove token and clear user even if the API call fails
      authApi.removeToken()
      user.value = null
      error.value = err.response?.data?.message || 'Logout failed. Please try again.'
      return { success: false, error: error.value }
    } finally {
      loading.value = false
    }
  }

  /**
   * Fetch current user (uses token from localStorage automatically)
   */
  const fetchUser = async () => {
    if (!authApi.getToken()) {
      user.value = null
      return { success: false }
    }

    loading.value = true
    error.value = null

    try {
      const response = await authApi.getUser()
      user.value = response.data
      return { success: true }
    } catch (err) {
      authApi.removeToken()
      user.value = null
      return { success: false }
    } finally {
      loading.value = false
    }
  }

  /**
   * Clear error
   */
  const clearError = () => {
    error.value = null
  }

  return {
    user,
    loading,
    error,
    isAuthenticated,
    login,
    register,
    logout,
    fetchUser,
    clearError,
  }
})