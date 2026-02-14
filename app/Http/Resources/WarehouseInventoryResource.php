<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseInventoryResource extends JsonResource
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
            'id'       => $this->id,
            'quantity' => $this->quantity,
            'warehouse'     =>[
                'id'        => $this->warehouse?->id,
                'name'      => $this->warehouse?->name,
                'location'  => $this->warehouse?->location,
            ], 
            'item'     =>[
                'id'        => $this->item?->id,
                'name'      => $this->item?->name,
                'sku'  => $this->item?->sku,
            ]
        ];
    }
}
