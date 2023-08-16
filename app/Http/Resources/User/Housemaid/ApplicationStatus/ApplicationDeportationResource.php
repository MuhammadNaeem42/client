<?php

namespace App\Http\Resources\User\Housemaid\ApplicationStatus;

use App\Http\Resources\User\ApplicationResource;
use App\Http\Resources\User\SponsorResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationDeportationResource extends JsonResource
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
            'flight_agent_name' => $this->flight_agent_name,
            'flight_no' => $this->flight_no,
            'sponsor_id' => $this->sponsor_id,
            'application_id' => $this->application_id,
            'created_by_id' => $this->created_by_id,
            'transaction_date' => $this->transaction_date,
            'arrival_date' => $this->arrival_date,
            'application_email_date' => $this->application_email_date,
            'reason'=> $this->reason,
            'days'=>$this->days ,
            'status' => $this->status,

            'sponsor' => new SponsorResource($this->whenLoaded('sponsor')),
            'application' => new ApplicationResource($this->whenLoaded('application')),
//            'created_by' => (new UserResource($this->whenLoaded('created_by')))->makeHidden(['all_permissions','current_permissions']),
            'created_by' => (new UserResource($this->whenLoaded('created_by'))),


            'cancellation_date' => $this->cancellation_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
