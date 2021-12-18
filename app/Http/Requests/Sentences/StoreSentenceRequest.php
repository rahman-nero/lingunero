<?php


namespace App\Http\Requests\Sentences;


use Illuminate\Foundation\Http\FormRequest;

final class StoreSentenceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'sentences.*.sentence' => ['required', 'string'],
            'sentences.*.translation' => ['required', 'string'],
        ];
    }

}
