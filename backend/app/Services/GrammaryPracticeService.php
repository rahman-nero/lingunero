<?php

namespace App\Services;

use App\Models\GrammaryPracticeStatistic;
use App\Repository\GrammaryPracticeRepository;
use Illuminate\Support\Collection;

/**
 * Сервис проверки ответов по практике грамматики и сохранения результата в статистику.
 */
final class GrammaryPracticeService
{
    public function __construct(
        private readonly GrammaryPracticeRepository $practiceRepository
    ) {
    }

    /**
     * Проверяет ответы пользователя, считает результат и сохраняет запись в grammary_practice_statistics.
     *
     * @param int   $grammaryId Идентификатор темы грамматики
     * @param int   $userId     Идентификатор пользователя
     * @param array $answers    Ответы: [ practice_id => user_answer (string), ... ]
     * @return array{ total: int, correct: int, statistic_id: int }
     */
    public function submitPractice(int $grammaryId, int $userId, array $answers): array
    {
        $practices = $this->practiceRepository->getByGrammaryId($grammaryId);
        $result = $this->checkAnswers($practices, $answers);

        $statistic = GrammaryPracticeStatistic::create([
            'grammary_id' => $grammaryId,
            'user_id' => $userId,
            'statistic' => [
                'total' => $result['total'],
                'correct' => $result['correct'],
                'details' => $result['details'],
            ],
        ]);

        return [
            'total' => $result['total'],
            'correct' => $result['correct'],
            'statistic_id' => $statistic->id,
        ];
    }

    /**
     * Сравнивает ответы пользователя с правильными (без учёта регистра, с trim).
     *
     * @param Collection<int, \App\Models\GrammaryPractice> $practices
     * @param array<string, string>                        $answers
     * @return array{ total: int, correct: int, details: array<int, array{ practice_id: int, correct: bool }> }
     */
    private function checkAnswers(Collection $practices, array $answers): array
    {
        $total = 0;
        $correct = 0;
        $details = [];

        foreach ($practices as $practice) {
            $userAnswer = $this->normalizeAnswer((string) ($answers[$practice->id] ?? $answers[(string) $practice->id] ?? ''));
            $correctAnswers = $this->normalizeCorrectAnswers($practice->answers ?? []);
            $isCorrect = $correctAnswers !== [] && in_array($userAnswer, $correctAnswers, true);

            $total++;
            if ($isCorrect) {
                $correct++;
            }
            $details[] = [
                'practice_id' => $practice->id,
                'correct' => $isCorrect,
            ];
        }

        return [
            'total' => $total,
            'correct' => $correct,
            'details' => $details,
        ];
    }

    /**
     * Нормализация строки ответа пользователя (trim + lower case).
     *
     * @param string $answer
     * @return string
     */
    private function normalizeAnswer(string $answer): string
    {
        return strtolower(trim($answer));
    }

    /**
     * Нормализация списка правильных ответов (каждый элемент trim + lower case).
     *
     * @param array $answers
     * @return array<int, string>
     */
    private function normalizeCorrectAnswers(array $answers): array
    {
        $result = [];
        foreach ($answers as $a) {
            $result[] = strtolower(trim((string) $a));
        }
        return array_values(array_filter($result, fn (string $s) => $s !== ''));
    }
}
