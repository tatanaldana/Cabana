<?php

namespace App\Http\Resources;

use App\Http\Requests\API\ProductoRequest;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetpromocioneResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id'=> $this->id,
            'promocione_id' => $this->promocione_id,
            'cantidad' => $this->cantidad,
            'porcentaje' => $this->porcentaje,
            'descuento' => $this->descuento,
            'subtotal' => $this->subtotal,
            'producto'=>new ProductoResource($this->whenLoaded('producto')),
        ];
    }
}
