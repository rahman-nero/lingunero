<?php

namespace App\Http\Controllers\API\V1\Grammary\Responses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * API Resource для одного задания практики по грамматике.
 *
 * @mixin \App\Models\GrammaryPractice
 */
class GrammaryPracticeResource extends JsonResource
{
    /**
     * Преобразование модели в массив для JSON-ответа.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'grammary_id' => $this->grammary_id,
            'union_id'   => $this->union_id,
            'title'      => $this->title,
            'type'       => $this->type instanceof \BackedEnum ? $this->type->value : $this->type,
            'question'   => $this->question,
            'answers'    => $this->answers,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
