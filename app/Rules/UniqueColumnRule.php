<?php

namespace App\Rules;

use App\Facade\RequestPrincipal;
use App\Model\Enums\GenericStatusConstant;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;


/**
 * Class UniqueColumnRule
 * @package App\Rules
 * This rule is used to check if a column value already
 * exists in the provided database table.
 *
 *This is useful to not allow uniqueness on a column, onces the value exists the rule returns a false;
 */
class UniqueColumnRule implements Rule
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
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     * @return bool|void
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

        $exists = DB::table($tableName)
            ->where($column, '=', $value)
            ->where('status', GenericStatusConstant::ACTIVE)
            ->exists();

        return !$exists;
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
