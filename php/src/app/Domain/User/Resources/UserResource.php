<?php

namespace App\Domain\User\Resources;

use App\Domain\Resource;
use App\Domain\Order\Resources\OrderResource;

class UserResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = [
            'id' => $this->id,
            'name' => $this->name,
            'nickname' => $this->nickname,
            'phone' => $this->phone,
            'email' => $this->email,
            'gender' => $this->gender,
        ];

        $relations = $this->getRelations();
        if (array_key_exists('latestOrder', $relations)) {
            $resource['latestOrder'] = $this->latestOrder ? new OrderResource($this->latestOrder) : null;
        }

        return $resource;
    }
}
