<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\DetpromocioneResource;

class ProductoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            
            'id' => $this->id,
            'nom_producto' => $this->nom_producto,
            'precio_producto' => $this->precio_producto,
            'detalle' => $this->detalle,
            'codigo' => $this->codigo,
            'categoria_id' => $this->categoria_id,
            'detpromociones'=>DetpromocioneResource::collection($this->whenLoaded('detpromociones')),
        ];
    }
}