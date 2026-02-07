<?php

namespace App\Http\Requests\API\V1\Grammary;

use App\Models\GrammaryPractice;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Валидация запроса на отправку ответов по практике грамматики.
 */
class SubmitPracticeRequest extends FormRequest
{
    /**
     * Разрешить выполнение запроса (пользователь должен быть аутентифицирован через маршрут).
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Правила валидации: answers — объект, ключи — id практик, значения — ответ пользователя (строка).
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'answers' => ['required', 'array'],
            'answers.*.id' => [
                'required',
                'integer',
                Rule::exists(GrammaryPractice::class)->where('grammary_id', $this->route('id')),
            ],
            'answers.*.value' => ['nullable', 'string'],
        ];
    }
}
