<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductoResource;


class CategoriaResource extends JsonResource
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
            'nombre'=>$this->nombre_cat,
            'fehca creada'=>$this->created_at,
            'fecha actualizada'=>$this->updated_at,
            'productos'=>ProductoResource::collection($this->whenLoaded('productos'))
        ];
    }
}
