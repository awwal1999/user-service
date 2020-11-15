<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed roles
 * @property mixed portalAccount
 */
class AccountRoleResource extends JsonResource
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
            'account' => new PortalAccountResource($this->portalAccount),
            'roles' => RoleResource::collection($this->roles)
        ];
    }
}
