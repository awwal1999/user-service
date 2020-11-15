<?php

namespace App\Http\Requests;

use App\Facade\Console;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string userIdentifier
 * @property string portalAccountCode
 * @property mixed roleCode
 */
class AssignRoleRequest extends FormRequest
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
            'userIdentifier' => 'required|user_info:identifier,exist',
            'portalAccountCode' => 'required|exist_column:portal_accounts,code'
        ];
    }

    public function messages()
    {
        return [
            'userIdentifier.required' => 'User identifier is required',
            'userIdentifier.user_info' => 'A valid user identifier must be provided',
            'portalAccountCode.required' => 'portalAccountCode is required',
            'portalAccountCode.exist_column' => 'portalAccount code does not exist',
        ];
    }
}
