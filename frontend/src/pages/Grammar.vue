<script setup>
import { ref, onMounted } from 'vue'
import { RouterLink } from 'vue-router'
import { getGrammaryList } from '@/api/grammary.js'
import CenterComponent from '../components/CenterComponent.vue'

const topics = ref([])
const loading = ref(true)
const error = ref(null)

onMounted(async () => {
  try {
    loading.value = true
    error.value = null
    const { data } = await getGrammaryList({ per_page: 100 })
    topics.value = data.data ?? []
  } catch (e) {
    error.value = e.response?.data?.message ?? 'Failed to load grammar topics'
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <CenterComponent>
    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">
          Grammar topics
        </h1>

        <div v-if="loading" class="text-gray-500 dark:text-gray-400">
          Loading…
        </div>

        <div v-else-if="error" class="text-red-600 dark:text-red-400">
          {{ error }}
        </div>

        <ul v-else-if="topics.length" class="space-y-1">
          <li v-for="topic in topics" :key="topic.id">
            <RouterLink
              :to="{ name: 'grammar-topic', params: { id: topic.id } }"
              class="block px-4 py-3 rounded-lg text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors"
            >
              {{ topic.name }}
            </RouterLink>
          </li>
        </ul>

        <p v-else class="text-gray-500 dark:text-gray-400">
          No grammar topics yet.
        </p>
  </CenterComponent>
</template>
