<?php


namespace App\Http\Request\user;
use \App\Http\Request\FormRequest;

class DeleteUserRequest extends FormRequest
{

    /**
     * @inheritDoc
     */
    public function authorize()
    {
        return true;
    }

    
    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            'id' => 'required'
        ];
    }
}
