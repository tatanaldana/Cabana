<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'access_token' => $this->access_token,
            'refresh_token'=>$this->refresh_token,
            'type_token'=>$this->token_type,
            'autorizacion' =>$this->scopes,
        ];
    }
}