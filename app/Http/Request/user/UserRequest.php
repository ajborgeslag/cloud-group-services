<?php


namespace App\Http\Request\user;


use App\Http\Request\FormRequest;


class UserRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:user,email',
            'password' => 'required',
            'locations' => 'required|array',
            'locations.*.id' => 'required|integer',
            'locations.*.roles' => 'required|array',
            'locations.*.roles.*.code' => 'required',
        ];
    }
}