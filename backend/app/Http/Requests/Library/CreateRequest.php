<?php


namespace App\Http\Requests\Library;


use Illuminate\Foundation\Http\FormRequest;

final class CreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'title' => 'required|string|min:2',
            'description' => 'nullable|string',
        ];
    }

}
