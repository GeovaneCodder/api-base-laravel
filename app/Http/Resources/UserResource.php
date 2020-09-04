<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        $content = $this
            ->profile
            ->content;

        return [
            'id' => $this->id,
            'full_name' => $content['first_name'] . ' ' . $content['last_name'],
            'first_name' => $content['first_name'],
            'last_name' => $content['last_name'],
            'email' => $this->email,
            'role' => $this->role,
        ];
    }
}
