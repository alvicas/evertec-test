<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'customer_mobile' => $this->customer_mobile,
            'customer_document_number' => $this->customer_document_number,
            'customer_document_type' => $this->customer_document_type,
            'product_id' => $this->product_id,
            'identifier_code' => $this->identifier_code,
            'total' => $this->total,
            'status' => $this->getStatus()
        ];
    }
}
