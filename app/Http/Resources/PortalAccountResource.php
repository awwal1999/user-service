<?php

namespace App\Http\Resources;

use App\Model\PortalAccount;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @property mixed name
 * @property mixed code
 */
class PortalAccountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'code' => $this->code,
        ];
    }
}
