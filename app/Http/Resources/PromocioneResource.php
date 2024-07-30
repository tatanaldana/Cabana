<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PromocioneResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'nom_promo'=>$this->nom_promo,
            'total_promo'=>$this->total_promo,
            'fecha creada'=>$this->created_at,
            'fecha actualizada'=>$this->updated_at,
            'detpromociones'=>DetpromocioneResource::collection($this->whenLoaded('detpromociones')),
        ];
    }
}
