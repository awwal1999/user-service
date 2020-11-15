<?php

namespace App\Http\Resources;

use App\Facade\Console;
use App\Facade\RequestPrincipal;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @method memberships()
 * @method user()
 * @method roles()
 */
class RequestPrincipalResource extends JsonResource
{

    private $token = null;

    public function token(string $token)
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
        if (is_null($this->token)) {
            $token = [
                'token' => $this->token
            ];
        }

        $membership = collect(RequestPrincipal::memberships())->map(function ($item, $index) {
            return (object)$item;
        });


        $response = [
            'user' => new UserResource($this->user()),
            'memberships' => AccountRoleResource::collection(collect($membership))
        ];

        return array_merge($response, $token);
    }
}
