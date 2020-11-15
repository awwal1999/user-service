<?php

namespace App\Http\Requests;

use App\Facade\Console;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property array role
 * @property array roles
 */
class RoleRequest extends FormRequest
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
            'roles' => 'required|array|between:1,20'
        ];


        $roles = $this->request->get('roles');
        if (is_null($roles)) {
            return $rules;
        }
        foreach ($roles as $key => $val) {
            $rules['roles.' . $key . '.name'] = 'required|string|unique_column:roles,name';
        }


        return $rules;
    }

    public function messages()
    {
        $messages = [
            'roles.required' => 'roles is required',
            'roles.array' => 'roles must be an array',
            'roles.between' => 'Max number of roles can only be 20 and min 1'
        ];


        $roles = $this->request->get('roles');

        if (is_null($roles)) {
            return $messages;
        }

        foreach ($roles as $key => $val) {
            $messages['roles.' . $key . '.name.required'] = 'Name must be provided';
            $messages['roles.' . $key . '.name.string'] = 'name must be a string';
            $messages['roles.' . $key . '.name.unique_column'] = 'name already exists';
        }

        return $messages;
    }


}
