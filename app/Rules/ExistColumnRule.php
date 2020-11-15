<?php

namespace App\Rules;

use App\Facade\Console;
use App\Facade\RequestPrincipal;
use App\Model\Enums\GenericStatusConstant;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ExistColumnRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     * @return bool
     */
    public function passes($attribute, $value, $parameters = [])
    {

        $column = 'id';
        if (empty($parameters)) {
            return true;
        }
        $tableName = $parameters[0];
        if (sizeof($parameters) == 2) {
            $column = $parameters[1];
        }

        return DB::table($tableName)
            ->where($column, '=', $value)
            ->where('status', GenericStatusConstant::ACTIVE)
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
