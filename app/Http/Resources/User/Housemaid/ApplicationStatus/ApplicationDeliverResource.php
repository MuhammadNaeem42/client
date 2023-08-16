<?php

namespace App\Http\Resources\User\Housemaid\ApplicationStatus;

use App\Http\Resources\User\ApplicationResource;
use App\Http\Resources\User\SponsorResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationDeliverResource extends JsonResource
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
            'sponsor_id' => $this->sponsor_id,
            'application_id' => $this->application_id,
            'deliver_date' => $this->deliver_date,
            'transaction_date' => $this->transaction_date,
            'paid_amount' => $this->paid_amount,
            'discount_amount' => $this->discount_amount,
            'total' => $this->total,
            'due' => $this->due,
            'pay_status' => $this->pay_status,
            'status'=>$this->status,
            'sponsor' => new SponsorResource($this->whenLoaded('sponsor')),
            'application' => new ApplicationResource($this->whenLoaded('application')),
//            'created_by' => (new UserResource($this->whenLoaded('created_by')))->makeHidden(['all_permissions','current_permissions']),
            'created_by' => (new UserResource($this->whenLoaded('created_by'))),

            'created_by_id' => $this->created_by_id,
            'updated_at' => $this->updated_at,
            'created_at'=> $this->created_at,

        ];
    }
}
