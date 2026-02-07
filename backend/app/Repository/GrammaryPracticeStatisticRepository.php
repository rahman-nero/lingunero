<?php

namespace App\Repository;

use App\Models\GrammaryPracticeStatistic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * @method Builder model()
 */
final class GrammaryPracticeStatisticRepository extends CoreRepository
{
    protected function getModel(): string
    {
        return GrammaryPracticeStatistic::class;
    }

    /**
     * Получение всех записей статистики по теме грамматики и пользователю (предыдущие попытки).
     *
     * @param int $grammaryId Идентификатор темы грамматики
     * @param int $userId    Идентификатор пользователя
     * @return Collection<int, GrammaryPracticeStatistic>
     */
    public function getByGrammaryAndUser(int $grammaryId, int $userId): Collection
    {
        return $this->model()
            ->where('grammary_id', $grammaryId)
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
