<script setup>
import { ref, onMounted, computed, watch } from 'vue'
import { useRoute, RouterLink } from 'vue-router'
import { getGrammaryById, getGrammaryPractices, submitGrammaryPractice } from '@/api/grammary.js'
import CenterComponent from '../components/CenterComponent.vue'

const route = useRoute()
const topic = ref(null)
const loading = ref(true)
const error = ref(null)

const id = computed(() => route.params.id)

/** Tab: 'test' | 'scores' */
const activeTab = ref('test')

const practicesByUnion = ref(null)
const practicesLoading = ref(false)
const practicesError = ref(null)
/** User answers keyed by practice id */
const answers = ref({})

const checkLoading = ref(false)
const checkError = ref(null)
/** Last check result: { total, correct, statistic_id } */
const checkResult = ref(null)

function formatCheckError (err) {
  if (err == null) return ''
  if (Array.isArray(err)) return err.join(', ')
  if (typeof err === 'object') return Object.values(err).flat().join(', ')
  return String(err)
}

/** Flatten practices API response into list of { unionId, items, title } for rendering */
const practiceGroups = computed(() => {
  const data = practicesByUnion.value?.data ?? practicesByUnion.value
  if (!data || typeof data !== 'object') return []
  return Object.entries(data).map(([unionId, items]) => {
    const list = items ?? []
    const title = list.find((t) => t?.title)?.title ?? null
    return { unionId, items: list, title }
  })
})

/** All practice tasks in order (for simple iteration) */
const allPractices = computed(() => {
  return practiceGroups.value.flatMap((g) => g.items)
})

async function loadTopic () {
  if (!id.value) return
  try {
    loading.value = true
    error.value = null
    const { data } = await getGrammaryById(id.value)
    topic.value = data.data ?? data
  } catch (e) {
    error.value = e.response?.data?.message ?? 'Topic not found'
  } finally {
    loading.value = false
  }
}

async function loadPractices () {
  if (!id.value) return
  try {
    practicesLoading.value = true
    practicesError.value = null
    const { data } = await getGrammaryPractices(id.value)
    practicesByUnion.value = data
    answers.value = {}
  } catch (e) {
    practicesError.value = e.response?.data?.message ?? 'Failed to load practices'
  } finally {
    practicesLoading.value = false
  }
}

function setAnswer (practiceId, value) {
  answers.value = { ...answers.value, [practiceId]: value }
}

/** Build payload for backend: answers array of { id, value } */
function buildPracticePayload () {
  return {
    answers: Object.entries(answers.value).map(([id, value]) => ({
      id: Number(id),
      value: value != null ? String(value) : ''
    }))
  }
}

async function checkAnswers () {
  if (!id.value || !practiceGroups.value?.length) return
  try {
    checkLoading.value = true
    checkError.value = null
    checkResult.value = null
    const payload = buildPracticePayload()
    const { data } = await submitGrammaryPractice(id.value, payload)
    checkResult.value = data
  } catch (e) {
    checkError.value = e.response?.data?.message ?? e.response?.data?.errors ?? 'Failed to check answers'
  } finally {
    checkLoading.value = false
  }
}

onMounted(loadTopic)

watch(activeTab, (tab) => {
  if (tab === 'test' && topic.value && !practicesByUnion.value && !practicesLoading.value) {
    loadPractices()
  }
})

watch(topic, (t) => {
  if (t && activeTab.value === 'test') loadPractices()
}, { immediate: true })
</script>

<template>
  <CenterComponent>
    <RouterLink
      :to="{ name: 'grammar' }"
      class="inline-block text-sm text-gray-600 dark:text-gray-400 hover:underline mb-4"
    >
      ← Back to Grammar
    </RouterLink>

    <div v-if="loading" class="text-gray-500 dark:text-gray-400">
      Loading…
    </div>

    <div v-else-if="error" class="text-red-600 dark:text-red-400">
      {{ error }}
    </div>

    <template v-else-if="topic">
      <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">
        {{ topic.name }}
      </h1>
      <div
        v-if="topic.content"
        class="prose dark:prose-invert text-gray-700 dark:text-gray-300 mb-8"
        v-html="topic.content"
      />
      <p v-else class="text-gray-500 dark:text-gray-400 mb-8">
        No content for this topic yet.
      </p>

      <!-- Tabs: Test, Previous scores -->
      <div class="border-b border-gray-200 dark:border-gray-700 mb-4">
        <nav class="flex gap-1" aria-label="Tabs">
          <button
            type="button"
            :class="[
              'px-4 py-2 text-sm font-medium rounded-t-lg transition-colors',
              activeTab === 'test'
                ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100'
                : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800'
            ]"
            @click="activeTab = 'test'"
          >
            Test
          </button>
          <button
            type="button"
            :class="[
              'px-4 py-2 text-sm font-medium rounded-t-lg transition-colors',
              activeTab === 'scores'
                ? 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100'
                : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800'
            ]"
            @click="activeTab = 'scores'"
          >
            Previous scores
          </button>
        </nav>
      </div>

      <!-- Test tab content -->
      <div v-show="activeTab === 'test'" class="space-y-6">
        <div v-if="practicesLoading" class="text-gray-500 dark:text-gray-400">
          Loading practices…
        </div>
        <div v-else-if="practicesError" class="text-red-600 dark:text-red-400">
          {{ practicesError }}
        </div>
        <template v-else-if="practiceGroups.length">
          <div
            v-for="group in practiceGroups"
            :key="group.unionId"
            class="space-y-4 p-4 rounded-lg bg-gray-50 dark:bg-gray-800/50"
          >
            <h3
              v-if="group.title"
              class="text-lg font-semibold text-gray-900 dark:text-gray-100 border-b border-gray-200 dark:border-gray-600 pb-2 mb-2"
            >
              {{ group.title }}
            </h3>
            <div
              v-for="task in group.items"
              :key="task.id"
              class="flex flex-col gap-2"
            >
              <p class="text-gray-800 dark:text-gray-200 font-medium">
                {{ task.question || '—' }}
              </p>
              <template v-if="task.type === 'word'">
                <input
                  :value="answers[task.id]"
                  type="text"
                  class="w-full max-w-md px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-gray-400 dark:focus:ring-gray-500 focus:border-transparent"
                  :placeholder="'Your answer'"
                  @input="setAnswer(task.id, $event.target.value)"
                />
              </template>
              <p v-else class="text-sm text-gray-500 dark:text-gray-400">
                Type "{{ task.type }}" is not supported yet.
              </p>
            </div>
          </div>

          <div class="flex flex-col gap-3">
            <button
              type="button"
              :disabled="checkLoading"
              class="self-start px-4 py-2 rounded-lg font-medium bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900 hover:bg-gray-800 dark:hover:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none transition-colors"
              @click="checkAnswers"
            >
              {{ checkLoading ? 'Checking…' : 'Check answers' }}
            </button>
            <p v-if="checkError" class="text-red-600 dark:text-red-400 text-sm">
              {{ formatCheckError(checkError) }}
            </p>
            <p
              v-else-if="checkResult"
              class="text-gray-700 dark:text-gray-300 font-medium"
            >
              Result: {{ checkResult.correct }} / {{ checkResult.total }} correct
            </p>
          </div>
        </template>
        <p v-else class="text-gray-500 dark:text-gray-400">
          No practice tasks for this topic yet.
        </p>
      </div>

      <!-- Previous scores tab content -->
      <div v-show="activeTab === 'scores'" class="text-gray-500 dark:text-gray-400">
        Previous scores will appear here.
      </div>
    </template>
  </CenterComponent>
</template>
