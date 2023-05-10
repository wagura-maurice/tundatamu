<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return array_filter([
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'account' => optional($this)->id ? AccountResource::make($this->whenLoaded('account')) : NULL,
            'access_token' => optional($this)->access_token,
            'created' => optional($this)->created_at ? Carbon::parse(optional($this)->created_at)->diffForHumans() : NULL,
            'updated' => optional($this)->updated_at ? Carbon::parse(optional($this)->updated_at)->diffForHumans() : NULL
        ]);
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'throwable' => array_filter([
                'status' => optional($request)->status,
                'message' => optional($request)->message
            ])
        ];
    }

    /**
     * Customize the outgoing response for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
    public function withResponse($request, $response)
    {
        $response->header('Accept', 'application/json');
    }
}
