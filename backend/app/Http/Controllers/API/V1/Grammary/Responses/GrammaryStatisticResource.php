<?php

namespace App\Http\Controllers\API\V1\Grammary\Responses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * API Resource для одной записи статистики практики по грамматике (предыдущий результат).
 *
 * @mixin \App\Models\GrammaryPracticeStatistic
 */
class GrammaryStatisticResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'statistic'   => $this->statistic,
            'created_at'  => $this->created_at?->toIso8601String(),
            'updated_at'  => $this->updated_at?->toIso8601String(),
        ];
    }
}
