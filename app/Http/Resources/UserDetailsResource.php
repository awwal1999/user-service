<?php

namespace App\Http\Resources;

use App\Facade\RequestPrincipal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed user
 * @property mixed memberships
 */
class UserDetailsResource extends JsonResource
{


    private $token;

    public function setToken($token)
    {
        $this->token = $token;
    }


    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {


        $token = [];
        if (isset($this->token)) {
            $token = [
                "token" => $this->token
            ];
        }

        $response = [
            'user' => new UserResource($this->user),
            'memberships' => AccountRoleResource::collection($this->memberships)
        ];
        return array_merge($response, $token);
    }
}
