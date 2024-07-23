<?php

namespace App\Http\Resources;

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
            'promocione_id' => $this->promocione_id,
            'cantidad' => $this->cantidad,
            'descuento' => $this->descuento,
            'subtotal' => $this->subtotal,
        ];
    }
}
