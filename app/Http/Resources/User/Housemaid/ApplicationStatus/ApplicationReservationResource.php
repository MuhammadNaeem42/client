<?php

namespace App\Http\Resources\User\Housemaid\ApplicationStatus;

use App\Http\Resources\User\ApplicationResource;
use App\Http\Resources\User\SponsorResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ApplicationReservationResource extends JsonResource
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
            'passport_id' => $this->passport_id,
            'note' => $this->note,
            'reservation_days' => $this->reservation_days,
            'reservation_date' => $this->reservation_date,
            'pay_due_date' => $this->pay_due_date,
            'deal_amount' => $this->deal_amount,
            'down_payment_amount' => $this->down_payment_amount,
            'paid_immediately' => $this->paid_immediately,
            'status' => $this->status,

            'application_id' => $this->application_id,
            'sponsor_id' => $this->sponsor_id,
            'created_by_id' => $this->created_by_id,

            'sponsor' => new SponsorResource($this->whenLoaded('sponsor')),
            'application' => new ApplicationResource($this->whenLoaded('application')),
//            'created_by' => (new UserResource($this->whenLoaded('created_by')))->makeHidden(['all_permissions','current_permissions']),
            'created_by' => (new UserResource($this->whenLoaded('created_by'))),

            'cancellation_date' => $this->cancellation_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
