<?php


namespace App\Http\Request\service;


use App\Http\Request\FormRequest;

class UpdateZipCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'elements' => 'required',
        ];
    }
}
