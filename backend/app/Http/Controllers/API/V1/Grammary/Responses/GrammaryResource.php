<?php

namespace App\Http\Controllers\API\V1\Grammary\Responses;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * API Resource для темы по грамматике (один элемент).
 *
 * @mixin \App\Models\Grammary
 */
class GrammaryResource extends JsonResource
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
            'name'       => $this->name,
            'content'    => $this->content,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
