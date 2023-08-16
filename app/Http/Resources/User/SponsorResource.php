<?php

namespace App\Http\Resources\User;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class SponsorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        $work_attachments = json_decode($this->work_attachments);
        $work_attachments_full = [];

        if (!empty($work_attachments)) {
            foreach ($work_attachments as $work_attachment)
                $work_attachments_full[] = asset($work_attachment);
        }

        return [
            'id' => $this->id,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'address_en' => $this->address_en,
            'address_ar' => $this->address_ar,

            'civil_id' => $this->civil_id,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'phone' => $this->phone,

            'language' => $this->language,
            'gender' => $this->gender,

            'photo' => $this->photo,
            'front_civil_photo' => $this->front_civil_photo,
            'back_civil_photo' => $this->back_civil_photo,
            'blood_type' => $this->blood_type,
            'expire_date_civil_card' => $this->expire_date_civil_card,
            'birth_date' => $this->birth_date,
            'unit_type' => $this->unit_type,
            'area' => $this->area,
            'block' => $this->block,
            'street' => $this->street,
            'unit_no' => $this->unit_no,
            'floor' => $this->floor,
            'building_no' => $this->building_no,
            'serial_no' => $this->serial_no,
            'paci_unit_no' => $this->paci_unit_no,
            'shipping_email' => $this->shipping_email,
            'phones' => $this->phones,

            'job_position' => $this->job_position,
            'work_attachments' => $work_attachments_full,

            'device_token' => $this->device_token,

            'country_id' => $this->country_id,
            'job_id' => $this->job_id,
            'created_by_id' => $this->created_by_id,
            'country' => new CountryResource($this->whenLoaded('country')),
            'job' => new JobResource($this->whenLoaded('job')),
            'user' => new UserResource($this->whenLoaded('user')),

            'is_block' => $this->is_block,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
