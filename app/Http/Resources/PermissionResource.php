<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string name
 * @property string code
 */
class PermissionResource extends JsonResource
{
    function toArray($request)
    {
        return [
            'name' => $this->name,
            'code' => $this->code
        ];
    }
}

