<?php

namespace App\Http\Resources\User\Housemaid\ApplicationStatus;

use App\Http\Resources\User\ApplicationResource;
use App\Http\Resources\User\SponsorResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResellResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'application_id' => $this->application_id,
            'sponsor_id' => $this->sponsor_id,

            'sponsor_refund' => $this->sponsor_refund,
            'paid_to_sponsor' => $this->paid_to_sponsor,
            'invoice_id' => $this->invoice_id,
            'invoice_status' => $this->invoice_status,
            'invoice_amount' => $this->invoice_amount,
            'invoice_due_amount' => $this->invoice_due_amount,
            'created_by_id' => $this->created_by_id,
            'status' => $this->status,
            'resell_date' => $this->resell_date,

            'sponsor' => new SponsorResource($this->whenLoaded('sponsor')),
            'application' => new ApplicationResource($this->whenLoaded('application')),
//            'created_by' => (new UserResource($this->whenLoaded('created_by')))->makeHidden(['all_permissions','current_permissions']),
            'created_by' => (new UserResource($this->whenLoaded('created_by'))),


            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
