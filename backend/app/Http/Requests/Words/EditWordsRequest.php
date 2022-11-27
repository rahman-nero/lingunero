<?php


namespace App\Http\Requests\Words;


use Illuminate\Foundation\Http\FormRequest;

final class EditWordsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'words.*.id' => 'exists:words,id',
            'words.*.word' => ['required', 'string'],
            'words.*.translation' => ['required', 'string'],
            'words.*.description' => ['nullable', 'string'],
        ];
    }

}
