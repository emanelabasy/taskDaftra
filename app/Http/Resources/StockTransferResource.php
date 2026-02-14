<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StockTransferResource extends JsonResource
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
            'id'           => $this->id,
            'quantity'     => $this->quantity,
            'status'       => $this->status?->name,
            'reference'    => $this->reference,
            'note'         => $this->note,
            'requested_by' => $this->requestedBy?->name,
            'requested_at' => $this->requested_at?->format('Y-m-d H:i:s'),
            'approved_at'  => $this->approved_at?->format('Y-m-d H:i:s'),
            'completed_at' => $this->completed_at?->format('Y-m-d H:i:s'),
            'rejected_at'  => $this->rejected_at?->format('Y-m-d H:i:s'),
            'created_at'   => $this->created_at?->format('Y-m-d H:i:s'),
            'fromWarehouse'     =>[
                'id'        => $this->fromWarehouse?->id,
                'name'      => $this->fromWarehouse?->name,
                'location'  => $this->fromWarehouse?->location,
            ],  
            'toWarehouse'     =>[
                'id'        => $this->toWarehouse?->id,
                'name'      => $this->toWarehouse?->name,
                'location'  => $this->toWarehouse?->location,
            ], 
            'item'     =>[
                'id'        => $this->item?->id,
                'name'      => $this->item?->name,
                'sku'  => $this->item?->sku,
            ]
        ];
    }
}
