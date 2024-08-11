<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VentaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id'=>$this->id,
            'metodo_pago'=>$this->metodo_pago,
            'estado'=>$this->estado,
            'total'=>$this->total,
            'created_at'=>$this->created_at->toDateTimeString(),
            'user_id'=>$this->user_id->toDateTimeString(),
            'detventa'=>DetventaResource::collection($this->whenLoaded('detventas')),
            'usuario'=>new UserResource($this->whenLoaded('user')),
        ];
    }
}
