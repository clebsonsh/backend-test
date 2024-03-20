<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RedirectLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'ip_address' => $this->ip_address,
            'user_agent' => $this->user_agent,
            'referer' => $this->referer,
            'query_params' => $this->query_params,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
