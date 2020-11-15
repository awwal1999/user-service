<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 21/05/2020
 * Time: 1:06 PM
 */

namespace App\Common\utils;


use App\Common\Contracts\ApiKeyUtils;

class ApiKeyUtilsImpl implements ApiKeyUtils
{

    public function generateAPIKey($cipher = 'AES-256-CBC'): string
    {
        $randomGenerator = random_bytes($cipher === 'AES-128-CBC' ? 16 : 32);
        return base64_encode($randomGenerator);
    }
}
