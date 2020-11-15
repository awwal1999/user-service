<?php
/**
 *  * Author: Oluwatobi Adenekan
 * Date: 21/05/2020
 * Time: 1:06 PM
 */

namespace App\Common\Contracts;


interface ApiKeyUtils
{

    public function generateAPIKey($cipher = 'AES-256-CBC'): string;
}
