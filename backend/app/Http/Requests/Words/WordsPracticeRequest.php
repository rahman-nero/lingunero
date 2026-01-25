<?php


namespace App\Http\Requests\Words;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WordsPracticeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'words' => ['required', 'array'],
            'words.*' => ['nullable', 'string']
        ];
    }

}
