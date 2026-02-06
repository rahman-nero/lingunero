<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import MenuComponent from '@/components/MenuComponent.vue'

const route = useRoute()

const showMenu = computed(() => {
  return !['login', 'register'].includes(route.name)
})
</script>

<template>
  <div class="min-h-screen bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors">
    <MenuComponent v-if="showMenu" />
    <slot />
  </div>
</template>

