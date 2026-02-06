import { useColorMode } from '@vueuse/core'
import { computed } from 'vue'

export function useTheme() {
  const mode = useColorMode({
    storageKey: 'theme',
    initialValue: 'auto',
  })

  const isDark = computed(() => mode.value === 'dark')

  const setTheme = (value) => {
    mode.value = value
  }

  return {
    mode,
    isDark,
    setTheme,
  }
}
