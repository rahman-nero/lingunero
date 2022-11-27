<?php


namespace App\Http\Requests\Library;


use Illuminate\Foundation\Http\FormRequest;

final class EditRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
        ];
    }

}
