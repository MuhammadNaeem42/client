<?php

namespace App\Http\Resources\User\Housemaid\ApplicationStatus;

use App\Http\Resources\User\ApplicationResource;
use App\Http\Resources\User\SponsorResource;
use App\Http\Resources\User\UserResource;
use App\Models\Application;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ApplicationVisaResource extends JsonResource
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
            'transaction_date' => $this->transaction_date,
            'sponsor_name_en' => $this->sponsor_name_en,
            'sponsor_name_ar' => $this->sponsor_name_ar,
            'sponsor_address_en' => $this->sponsor_address_en,
            'sponsor_address_ar' => $this->sponsor_address_ar,
            'place_of_issue' => $this->place_of_issue,


            'passport_id' => $this->passport_id,
            'visa_issue_days' => $this->visa_issue_days,
            'visa_received_days' => $this->visa_received_days,
            'visa_no' => $this->visa_no,
            'visa_file_no' => $this->visa_file_no,
            'photo' => $this->photo,
            'visa_issue_date' => $this->visa_issue_date,
            'visa_expiry_date' => $this->visa_expiry_date,
            'visa_received_date' => $this->visa_received_date,
            'visa_send_date' => $this->visa_send_date,

            'housemaid_unified_no' => $this->housemaid_unified_no,
            'sponsor_unified_no' => $this->sponsor_unified_no,

            'note' => $this->note,

            'visa_status' => $this->visa_status,
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
