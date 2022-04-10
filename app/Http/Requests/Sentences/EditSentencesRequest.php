<?php


namespace App\Http\Requests\Sentences;


use Illuminate\Foundation\Http\FormRequest;

final class EditSentencesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'sentences.*.id' => 'exists:sentences,id',
            'sentences.*.sentence' => ['required', 'string'],
            'sentences.*.translation' => ['required', 'string'],
        ];
    }

}
