<script setup>
import { ref } from 'vue'
import { RouterLink, useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const router = useRouter()
const authStore = useAuthStore()

const mobileMenuOpen = ref(false)
const profileDropdownOpen = ref(false)

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

const handleLogout = async () => {
  await authStore.logout()
  profileDropdownOpen.value = false
  router.push({ name: 'login' })
}
</script>

<template>
  <nav class="bg-white shadow">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 justify-between">
        <!-- Logo + Nav Links -->
        <div class="flex">
          <!-- Logo -->
          <div class="flex shrink-0 items-center">
            <RouterLink :to="{ name: 'home' }" class="text-xl font-bold text-indigo-600">
              Lingunero
            </RouterLink>
          </div>

          <!-- Desktop Nav Links -->
          <div class="hidden sm:ml-8 sm:flex">
            <RouterLink
              v-for="link in navLinks"
              :key="link.name"
              :to="link.to"
              class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50 transition-colors"
              active-class="text-indigo-600 bg-indigo-50"
            >
              {{ link.name }}
            </RouterLink>
          </div>
        </div>

        <!-- Profile Dropdown (Desktop) -->
        <div class="hidden sm:ml-6 sm:flex sm:items-center">
          <div class="relative">
            <button
              @click="toggleProfileDropdown"
              class="flex items-center gap-2 rounded-full bg-gray-100 px-3 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-200 transition-colors focus:outline-none cursor-pointer"
            >
              <div class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 text-white text-sm font-semibold">
                {{ authStore.user?.name?.charAt(0)?.toUpperCase() || '?' }}
              </div>
              <span class="max-w-[120px] truncate">{{ authStore.user?.name || 'User' }}</span>
              <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5"
              >
                <RouterLink
                  :to="{ name: 'home' }"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >
                  Profile
                </RouterLink>
                <RouterLink
                  :to="{ name: 'home' }"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                >
                  Settings
                </RouterLink>
                <button
                  @click="handleLogout"
                  class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
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
            class="inline-flex items-center justify-center rounded-md p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700 focus:outline-none transition-colors"
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
      <div v-if="mobileMenuOpen" class="sm:hidden border-t border-gray-200">
        <!-- Nav Links -->
        <div class="space-y-1 px-3 py-3">
          <RouterLink
            v-for="link in navLinks"
            :key="link.name"
            :to="link.to"
            @click="mobileMenuOpen = false"
            class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-50 hover:text-indigo-600 transition-colors"
            active-class="text-indigo-600 bg-indigo-50"
          >
            {{ link.name }}
          </RouterLink>
        </div>

        <!-- Profile Section -->
        <div class="border-t border-gray-200 px-3 py-3">
          <div class="flex items-center gap-3 px-3 py-2">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-600 text-white font-semibold">
              {{ authStore.user?.name?.charAt(0)?.toUpperCase() || '?' }}
            </div>
            <div>
              <div class="text-base font-medium text-gray-800">{{ authStore.user?.name || 'User' }}</div>
              <div class="text-sm text-gray-500">{{ authStore.user?.email || '' }}</div>
            </div>
          </div>
          <div class="mt-2 space-y-1">
            <RouterLink
              :to="{ name: 'home' }"
              @click="mobileMenuOpen = false"
              class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-50"
            >
              Profile
            </RouterLink>
            <RouterLink
              :to="{ name: 'home' }"
              @click="mobileMenuOpen = false"
              class="block rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-50"
            >
              Settings
            </RouterLink>
            <button
              @click="handleLogout"
              class="block w-full text-left rounded-md px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-50"
            >
              Logout
            </button>
          </div>
        </div>
      </div>
    </Transition>
  </nav>
</template>
