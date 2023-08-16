<?php

namespace App\Http\Resources\User\Housemaid;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ApplicationExternalOfficeTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'note' => $this->note,
            'external_office_transaction_id' => $this->external_office_transaction_id,
            'application_id' => $this->application_id,
            'created_by_id' => $this->created_by_id,

            'external_office_transaction' => $this->whenLoaded('external_office_transaction'),
            'application' => $this->whenLoaded('application'),
            'created_by' => $this->whenLoaded('created_by'),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
