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
  <div class="min-h-screen">
    <MenuComponent v-if="showMenu" />
    <slot />
  </div>
</template>

