<?php

namespace App\Http\Controllers\API\V1\Grammary\Responses;

use Illuminate\Support\Collection;

/**
 * Формирование JSON-ответа со списком практик, сгруппированных по union_id.
 */
final class GrammaryPracticesGroupedResponse
{
    /**
     * Преобразует коллекцию практик в массив, сгруппированный по union_id.
     * Ключи — union_id, значения — массивы элементов практик для этой группы.
     *
     * @param Collection $practices Коллекция моделей GrammaryPractice
     * @return array<string, array<int, array<string, mixed>>>
     */
    public static function toArray(Collection $practices): array
    {
        $grouped = $practices->groupBy('union_id');

        return $grouped->map(function (Collection $group) {
            return GrammaryPracticeResource::collection($group)->resolve();
        })
        ->values()
        ->toArray();
    }
}
