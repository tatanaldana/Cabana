<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class DetventaResource extends JsonResource
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
            'nom_producto'=> $this->nom_producto,
            'pre_producto'=>$this->pre_producto,
            'cantidad'=>$this->cantidad,
            'subtotal'=>$this->subtotal,
            'venta_id'=>$this->venta_id,
        ];
    }
}
