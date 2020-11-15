<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed firstName
 * @property mixed lastName
 * @property mixed username
 * @property mixed middleName
 * @property mixed email
 * @property mixed identifier
 * @property mixed gender
 * @property mixed nin
 * @property mixed bvn
 * @property mixed mothersMaidenName
 */
class UserResource extends JsonResource
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
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'username' => $this->username,
            'middleName' => $this->middleName,
            'email' => $this->email,
            'identifier' => $this->identifier,
            'gender' => $this->gender,
            'nin' => $this->nin,
            'bvn' => $this->bvn,
            'mothersMaidenName' => $this->mothersMaidenName,
        ];
    }
}
