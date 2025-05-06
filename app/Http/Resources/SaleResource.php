<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
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
            'client_id'=>$this->client_id,
            'date'=>$this->date,
            'total'=>$this->total,
            'discount_id'=>$this->discount_id,
            'subtotal'=>$this->subtotal
        ];
    }
}
