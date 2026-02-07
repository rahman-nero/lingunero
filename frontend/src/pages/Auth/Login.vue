<script setup>
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const authStore = useAuthStore()

const form = reactive({
  email: '',
  password: '',
  remember: false,
})

const formErrors = ref({})
const showPassword = ref(false)
const isSubmitting = ref(false)

const validateForm = () => {
  const errors = {}

  if (!form.email) {
    errors.email = 'Email is required'
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) {
    errors.email = 'Please enter a valid email address'
  }

  if (!form.password) {
    errors.password = 'Password is required'
  } else if (form.password.length < 8) {
    errors.password = 'Password must be at least 8 characters'
  }

  formErrors.value = errors
  return Object.keys(errors).length === 0
}

const handleSubmit = async () => {
  authStore.clearError()

  if (!validateForm()) {
    return
  }

  isSubmitting.value = true

  const result = await authStore.login({
    email: form.email,
    password: form.password,
    remember: form.remember,
  })

  isSubmitting.value = false

  if (result.success) {
    router.push('/')
  } else if (result.errors) {
    formErrors.value = result.errors
  }
}

const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value
}
</script>

<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 px-4 py-12 transition-colors">
    <div class="w-full max-w-md">
      <!-- Card -->
      <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl dark:shadow-gray-900/50 p-8 transition-colors">
        <!-- Header -->
        <div class="text-center mb-8">
          <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">Welcome back</h1>
          <p class="text-gray-600 dark:text-gray-400">Sign in to continue learning</p>
        </div>

        <!-- Error Message -->
        <div
          v-if="authStore.error"
          class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg text-red-700 dark:text-red-300 text-sm"
        >
          {{ authStore.error }}
        </div>

        <!-- Form -->
        <form @submit.prevent="handleSubmit" class="space-y-6">
          <!-- Email Field -->
          <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
              Email address
            </label>
            <input
              id="email"
              v-model="form.email"
              type="email"
              autocomplete="email"
              :class="[
                'w-full px-4 py-3 border rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 transition-colors focus:outline-none focus:ring-2',
                formErrors.email
                  ? 'border-red-300 dark:border-red-700 focus:border-red-500 focus:ring-red-200 dark:focus:ring-red-900/50'
                  : 'border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-200 dark:focus:ring-indigo-900/50'
              ]"
              :disabled="isSubmitting"
              placeholder="you@example.com"
            />
            <p v-if="formErrors.email" class="mt-2 text-sm text-red-600 dark:text-red-400">
              {{ formErrors.email[0] }}
            </p>
          </div>

          <!-- Password Field -->
          <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
              Password
            </label>
            <div class="relative">
              <input
                id="password"
                v-model="form.password"
                :type="showPassword ? 'text' : 'password'"
                autocomplete="current-password"
                :class="[
                  'w-full px-4 py-3 border rounded-lg pr-12 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 transition-colors focus:outline-none focus:ring-2',
                  formErrors.password
                    ? 'border-red-300 dark:border-red-700 focus:border-red-500 focus:ring-red-200 dark:focus:ring-red-900/50'
                    : 'border-gray-300 dark:border-gray-600 focus:border-indigo-500 focus:ring-indigo-200 dark:focus:ring-indigo-900/50'
                ]"
                :disabled="isSubmitting"
                placeholder="Enter your password"
              />
              <button
                type="button"
                @click="togglePasswordVisibility"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors"
                :disabled="isSubmitting"
              >
                <svg
                  v-if="showPassword"
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"
                  />
                </svg>
                <svg
                  v-else
                  xmlns="http://www.w3.org/2000/svg"
                  class="h-5 w-5"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                  />
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                  />
                </svg>
              </button>
            </div>
            <p v-if="formErrors.password" class="mt-2 text-sm text-red-600 dark:text-red-400">
              {{ formErrors.password[0] }}
            </p>
          </div>

          <!-- Remember Me -->
          <div class="flex items-center">
            <input
              id="remember"
              v-model="form.remember"
              type="checkbox"
              class="h-4 w-4 text-indigo-600 dark:text-indigo-500 focus:ring-indigo-500 dark:focus:ring-indigo-600 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded"
              :disabled="isSubmitting"
            />
            <label for="remember" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
              Remember me
            </label>
          </div>

          <!-- Submit Button -->
          <button
            type="submit"
            :disabled="isSubmitting"
            :class="[
              'w-full py-3 px-4 rounded-lg font-medium text-white transition-all duration-200',
              isSubmitting
                ? 'bg-indigo-400 dark:bg-indigo-500 cursor-not-allowed'
                : 'bg-indigo-600 dark:bg-indigo-500 hover:bg-indigo-700 dark:hover:bg-indigo-600 active:scale-98 shadow-sm hover:shadow-md'
            ]"
          >
            <span v-if="isSubmitting" class="flex items-center justify-center">
              <svg
                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
              >
                <circle
                  class="opacity-25"
                  cx="12"
                  cy="12"
                  r="10"
                  stroke="currentColor"
                  stroke-width="4"
                ></circle>
                <path
                  class="opacity-75"
                  fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                ></path>
              </svg>
              Signing in...
            </span>
            <span v-else>Sign in</span>
          </button>
        </form>

        <!-- Register Link -->
        <div class="mt-6 text-center">
          <p class="text-sm text-gray-600 dark:text-gray-400">
            Don't have an account?
            <router-link
              to="/register"
              class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 transition-colors"
            >
              Sign up
            </router-link>
          </p>
        </div>
      </div>

      <!-- Footer -->
      <p class="mt-8 text-center text-sm text-gray-600 dark:text-gray-400">
        Lingunero - English Language Learning
      </p>
    </div>
  </div>
</template>