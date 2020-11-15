<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'username' => 'required|user_info:username',
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|user_info:email',
            'password' => 'required',
            'gender' => 'gender',
            'portalAccountTypeCode' => 'exist_column:portal_account_types,code'
        ];
    }


    public function messages()
    {
        return [
            'email.user_info' => 'Email has already been used',
            'portalAccountTypeCode.exist_column' => 'AccountType does not exist for client',
            'username.user_info' => 'username already exist'];
    }
}
