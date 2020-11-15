<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string permissionCode
 * @property mixed roleCode
 */
class PermissionAssignRequest extends FormRequest
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
            'roleCode' => 'required|string|exist_column:roles,code'
        ];
    }

    public function messages()
    {
        return [
            'roleCode.required' => 'roleCode is required',
            'roleCode.exist_column' => 'roleCode does not exist'
        ];
    }
}
