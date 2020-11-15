<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 15/04/2020
 * Time: 1:23 PM
 */

namespace App\Exceptions;


use Exception;
use Throwable;

class UnexpectedEnumValueException extends Exception
{

    public function __construct()
    {
        parent::__construct("Enum with value does not exist");
    }
}
