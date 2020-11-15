<?php

namespace App\Rules;

use App\Model\Enums\GenderTypeConstant;
use Illuminate\Contracts\Validation\Rule;

class GenderStatusRule implements Rule
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
     * @return bool
     */
    public function passes($attribute, $value)
    {
        //
        if (is_null($value) && empty($value)) {
            return true;
        }


        return GenderTypeConstant::isValidValue($value);

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
