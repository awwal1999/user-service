<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 07/04/2020
 * Time: 12:21 PM
 */

namespace App\Facade;


use App\Conf\StandardConsoleLoggerService;
use Illuminate\Support\Facades\Facade;


/**
 * @see StandardConsoleLoggerService
 * @method static log($message)
 */
class Console extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'console_log';
    }
}
