<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 06/04/2020
 * Time: 9:54 PM
 */


/**
 * This will remove all the whitespaces in a string
 * Eg $string =  'Paneer Pakoda dish'; will be 'PaneerPakodaDish'
 * @param mixed
 * @return string|string[]|null
 */
function delete_white_spaces($value)
{

    if (!is_string($value)) {
        return $value;
    }
    $s = ucfirst($value);
    $bar = ucwords(strtolower($s));
    return preg_replace('/\s+/', '', $bar);

}
