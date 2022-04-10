<?php


namespace App\Http\Requests\Sentences;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SentencesPracticeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'sentences' => ['required', 'array'],
            'sentences.*' => ['nullable', 'string']
        ];
    }

}
