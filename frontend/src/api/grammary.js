import axios, { V1_BASE } from '@/api/config.js'

/**
 * Get paginated list of grammar topics.
 * @param {Object} [params] - Optional query params, e.g. { per_page: 100 }
 * @returns {Promise<{ data: Array<{ id: number, name: string, content: string|null, created_at: string, updated_at: string }> }>}
 */
export const getGrammaryList = async (params = {}) => {
  return axios.get(`${V1_BASE}/grammary`, { params })
}

/**
 * Get a single grammar topic by id.
 * @param {number} id - Grammar topic id
 * @returns {Promise<{ data: { id: number, name: string, content: string|null, created_at: string, updated_at: string } }>}
 */
export const getGrammaryById = async (id) => {
  return axios.get(`${V1_BASE}/grammary/${id}`)
}

/**
 * Get practices for a grammar topic (grouped by union_id).
 * @param {number} id - Grammar topic id
 * @returns {Promise<{ data: { data: Record<string, Array<{ id: number, grammary_id: number, union_id: string, title: string|null, type: string, question: string|null, answers: array, created_at: string, updated_at: string }>> }>}
 */
export const getGrammaryPractices = async (id) => {
  return axios.get(`${V1_BASE}/grammary/${id}/practices`)
}

/**
 * Submit practice answers for checking. Body must match backend: answers array of { id, value }.
 * @param {number} topicId - Grammar topic id (grammary_id)
 * @param {{ answers: Array<{ id: number, value: string }> }} payload - { answers: [ { id: practiceId, value: userAnswer }, ... ] }
 * @returns {Promise<{ data: { total: number, correct: number, statistic_id: number } }>}
 */
export const submitGrammaryPractice = async (topicId, payload) => {
  return axios.post(`${V1_BASE}/grammary/${topicId}/practices`, payload)
}

/**
 * Get current user's previous statistics (scores) for a grammar topic.
 * @param {number} topicId - Grammar topic id (grammary_id)
 * @returns {Promise<{ data: { data: Array<{ id: number, statistic: { total: number, correct: number, details: Array<{ id: number, question: string|null, answers: string[], user_answer: string, correct: boolean, union_id: string, title: string }> }, created_at: string, updated_at: string }> } }>}
 */
export const getGrammaryStatistics = async (topicId) => {
  return axios.get(`${V1_BASE}/grammary/${topicId}/statistics`)
}
