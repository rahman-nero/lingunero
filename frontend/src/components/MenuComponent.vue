<script setup>
import { ref } from 'vue'
import { RouterLink, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import { useTheme } from '@/composables/useTheme'

const router = useRouter()
const authStore = useAuthStore()
const { mode, setTheme } = useTheme()

const mobileMenuOpen = ref(false)
const profileDropdownOpen = ref(false)
const themeDropdownOpen = ref(false)

const navLinks = [
  { name: 'Home', to: { name: 'home' } },
  { name: 'Grammar', to: { name: 'grammar' } },
  { name: 'Practice', to: { name: 'practice' } },
  { name: 'Words', to: { name: 'words' } },
]

const toggleMobileMenu = () => {
  mobileMenuOpen.value = !mobileMenuOpen.value
}

const toggleProfileDropdown = () => {
  profileDropdownOpen.value = !profileDropdownOpen.value
}

const closeProfileDropdown = () => {
  profileDropdownOpen.value = false
}

const toggleThemeDropdown = () => {
  themeDropdownOpen.value = !themeDropdownOpen.value
}

const closeThemeDropdown = () => {
  themeDropdownOpen.value = false
}

const handleThemeChange = (newTheme) => {
  setTheme(newTheme)
  closeThemeDropdown()
}

const handleLogout = async () => {
  await authStore.logout()
  profileDropdownOpen.value = false
  router.push({ name: 'login' })
}
</script>

<template>
  <nav class="bg-white dark:bg-gray-800 shadow dark:shadow-gray-700/50 transition-colors">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 justify-between">
        <!-- Logo + Nav Links -->
        <div class="flex">
          <!-- Logo -->
          <div class="flex shrink-0 items-center">
            <RouterLink :to="{ name: 'home' }" class="text-xl font-bold text-indigo-600 dark:text-indigo-400">
              Lingunero
            </RouterLink>
          </div>

          <!-- Desktop Nav Links -->
          <div class="hidden sm:ml-8 sm:flex">
            <RouterLink
              v-for="link in navLinks"
              :key="link.name"
              :to="link.to"
              class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
              active-class="text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-gray-700"
            >
              {{ link.name }}
            </RouterLink>
          </div>
        </div>

        <!-- Theme Toggle + Profile Dropdown (Desktop) -->
        <div class="hidden sm:ml-6 sm:flex sm:items-center sm:gap-3">
          <!-- Theme Toggle Dropdown -->
          <div class="relative">
            <button
              @click="toggleThemeDropdown"
              class="flex items-center justify-center h-9 w-9 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors focus:outline-none"
              title="Change theme"
            >
              <!-- Sun Icon (Light) -->
              <svg v-if="mode === 'light'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
              </svg>
              <!-- Moon Icon (Dark) -->
              <svg v-else-if="mode === 'dark'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
              </svg>
              <!-- Computer Icon (Auto) -->
              <svg v-else class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
            </button>

            <!-- Theme Dropdown Menu -->
            <Transition
              enter-active-class="transition ease-out duration-100"
              enter-from-class="transform opacity-0 scale-95"
              enter-to-class="transform opacity-100 scale-100"
              leave-active-class="transition ease-in duration-75"
              leave-from-class="transform opacity-100 scale-100"
              leave-to-class="transform opacity-0 scale-95"
            >
              <div
                v-if="themeDropdownOpen"
                @click="closeThemeDropdown"
                class="absolute right-0 z-10 mt-2 w-40 origin-top-right rounded-md bg-white dark:bg-gray-800 py-1 shadow-lg ring-1 ring-black/5 dark:ring-gray-700"
              >
                <button
                  @click="handleThemeChange('light')"
                  :class="[
                    'flex items-center w-full gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors',
                    mode === 'light' && 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400'
                  ]"
                >
                  <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                  </svg>
                  Light
                </button>
                <button
                  @click="handleThemeChange('dark')"
                  :class="[
                    'flex items-center w-full gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors',
                    mode === 'dark' && 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400'
                  ]"
                >
                  <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                  </svg>
                  Dark
                </button>
                <button
                  @click="handleThemeChange('auto')"
                  :class="[
                    'flex items-center w-full gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors',
                    mode === 'auto' && 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400'
                  ]"
                >
                  <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                  System
                </button>
              </div>
            </Transition>
          </div>

          <!-- Profile Dropdown -->
          <div class="relative">
            <button
              @click="toggleProfileDropdown"
              class="flex items-center gap-2 rounded-full bg-gray-100 dark:bg-gray-700 px-3 py-1.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors focus:outline-none cursor-pointer"
            >
              <div class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 dark:bg-indigo-500 text-white text-sm font-semibold">
                {{ authStore.user?.name?.charAt(0)?.toUpperCase() || '?' }}
              </div>
              <span class="max-w-[120px] truncate">{{ authStore.user?.name || 'User' }}</span>
              <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <!-- Dropdown Menu -->
            <Transition
              enter-active-class="transition ease-out duration-100"
              enter-from-class="transform opacity-0 scale-95"
              enter-to-class="transform opacity-100 scale-100"
              leave-active-class="transition ease-in duration-75"
              leave-from-class="transform opacity-100 scale-100"
              leave-to-class="transform opacity-0 scale-95"
            >
              <div
                v-if="profileDropdownOpen"
                @click="closeProfileDropdown"
                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white dark:bg-gray-800 py-1 shadow-lg ring-1 ring-black/5 dark:ring-gray-700"
              >
                <RouterLink
                  :to="{ name: 'home' }"
                  class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                >
                  Profile
                </RouterLink>
                <RouterLink
                  :to="{ name: 'home' }"
                  class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                >
                  Settings
                </RouterLink>
                <button
                  @click="handleLogout"
                  class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                >
                  Logout
                </button>
              </div>
            </Transition>
          </div>
        </div>

        <!-- Mobile Menu Button -->
        <div class="flex items-center sm:hidden">
          <button
            @click="toggleMobileMenu"
            class="inline-flex items-center justify-center rounded-md p-2 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition-colors"
          >
            <svg v-if="!mobileMenuOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg v-else class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile Menu -->
    <Transition
      enter-active-class="transition ease-out duration-200"
      enter-from-class="opacity-0 -translate-y-1"
      enter-to-class="opacity-100 translate-y-0"
      leave-active-class="transition ease-in duration-150"
      leave-from-class="opacity-100 translate-y-0"
      leave-to-class="opacity-0 -translate-y-1"
    >
      <div v-if="mobileMenuOpen" class="sm:hidden border-t border-gray-200 dark:border-gray-700">
        <!-- Nav Links -->
        <div class="space-y-1 px-3 py-3">
          <RouterLink
            v-for="link in navLinks"
            :key="link.name"
            :to="link.to"
            @click="mobileMenuOpen = false"
            class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors"
            active-class="text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-gray-700"
          >
            {{ link.name }}
          </RouterLink>
        </div>

        <!-- Profile Section -->
        <div class="border-t border-gray-200 dark:border-gray-700 px-3 py-3">
          <div class="flex items-center gap-3 px-3 py-2">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-600 dark:bg-indigo-500 text-white font-semibold">
              {{ authStore.user?.name?.charAt(0)?.toUpperCase() || '?' }}
            </div>
            <div>
              <div class="text-base font-medium text-gray-800 dark:text-gray-200">{{ authStore.user?.name || 'User' }}</div>
              <div class="text-sm text-gray-500 dark:text-gray-400">{{ authStore.user?.email || '' }}</div>
            </div>
          </div>
          <div class="mt-2 space-y-1">
            <RouterLink
              :to="{ name: 'home' }"
              @click="mobileMenuOpen = false"
              class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
            >
              Profile
            </RouterLink>
            <RouterLink
              :to="{ name: 'home' }"
              @click="mobileMenuOpen = false"
              class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
            >
              Settings
            </RouterLink>

            <!-- Theme Options in Mobile -->
            <div class="pt-2 border-t border-gray-200 dark:border-gray-700">
              <div class="px-3 py-1 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Theme</div>
              <button
                @click="handleThemeChange('light'); mobileMenuOpen = false"
                :class="[
                  'flex items-center w-full gap-3 rounded-md px-3 py-2 text-base font-medium transition-colors',
                  mode === 'light'
                    ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-gray-700'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'
                ]"
              >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Light
              </button>
              <button
                @click="handleThemeChange('dark'); mobileMenuOpen = false"
                :class="[
                  'flex items-center w-full gap-3 rounded-md px-3 py-2 text-base font-medium transition-colors',
                  mode === 'dark'
                    ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-gray-700'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'
                ]"
              >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
                Dark
              </button>
              <button
                @click="handleThemeChange('auto'); mobileMenuOpen = false"
                :class="[
                  'flex items-center w-full gap-3 rounded-md px-3 py-2 text-base font-medium transition-colors',
                  mode === 'auto'
                    ? 'text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-gray-700'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700'
                ]"
              >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                System
              </button>
            </div>

            <button
              @click="handleLogout"
              class="block w-full text-left rounded-md px-3 py-2 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
            >
              Logout
            </button>
          </div>
        </div>
      </div>
    </Transition>
  </nav>
</template>
