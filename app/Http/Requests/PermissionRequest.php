<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed permissions
 */
class PermissionRequest extends FormRequest
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
        $rules = [
            'permissions' => 'required|array|between:1,20'
        ];


        $permissions = $this->request->get('permissions');
        if (is_null($permissions)) {
            return $rules;
        }
        foreach ($permissions as $key => $val) {
            $rules['permissions.' . $key . '.name'] = 'required|string|unique_column:permissions,name';
        }


        return $rules;
    }

    public function messages()
    {

        $messages = [
            'permissions.required' => 'permissions is required',
            'permissions.array' => 'permissions must be an array',
            'permissions.between' => 'Max number of roles can only be 20 and min 1'
        ];


        $permissions = $this->request->get('permissions');

        if (is_null($permissions)) {
            return $messages;
        }

        foreach ($permissions as $key => $val) {
            $messages['permissions.' . $key . '.name.required'] = 'Name must be provided';
            $messages['permissions.' . $key . '.name.string'] = 'name must be a string';
            $messages['permissions.' . $key . '.name.unique_column'] = 'name already exists';
        }

        return $messages;

    }
}
