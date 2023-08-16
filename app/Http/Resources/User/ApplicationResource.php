<?php

namespace App\Http\Resources\User;

use App\Http\Resources\User\Accounting\CurrencyResource;
use App\Http\Resources\User\Housemaid\ApplicationStatus\ApplicationArrivalResource;
use App\Http\Resources\User\Housemaid\ApplicationStatus\ApplicationDeliverResource;
use App\Http\Resources\User\Housemaid\ApplicationStatus\ApplicationDeportationResource;
use App\Http\Resources\User\Housemaid\ApplicationStatus\ApplicationExpectedArrivalResource;
use App\Http\Resources\User\Housemaid\ApplicationStatus\ApplicationResellResource;
use App\Http\Resources\User\Housemaid\ApplicationStatus\ApplicationReservationResource;
use App\Http\Resources\User\Housemaid\ApplicationStatus\ApplicationVisaResource;
use App\Http\Resources\User\Office\ExternalOfficeResource;
use App\Http\Resources\User\Office\InternalOfficeResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class ApplicationResource extends JsonResource
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
            'code' => $this->code,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'address_en' => $this->address_en,
            'address_ar' => $this->address_ar,
            'age' => $this->age,
            'birth_date' => $this->birth_date,
            'gender' => $this->gender,
            'marital_status' => $this->marital_status,
            'kids_no' => $this->kids_no,
            'photo' => $this->photo,
            'full_body_photo' => $this->full_body_photo,


            'housemaid_price' => $this->housemaid_price,
            'salary' => $this->salary,
            'office_commission' => $this->office_commission,
            'currency_id' => $this->currency_id,
            'external_office_id' => $this->external_office_id,
            'internal_office_id' => $this->internal_office_id,
            'sponsor_id' => $this->sponsor_id,


            'passport_no' => $this->passport_no,
            'passport_issue_date' => $this->passport_issue_date,
            'passport_expiry_date' => $this->passport_expiry_date,
            'place_birth' => $this->place_birth,
            'country_id' => $this->country_id,


            'english_skills' => $this->english_skills,
            'arabic_skills' => $this->arabic_skills,
            'experience' => $this->experience,
            'experience_details' => $this->experience_details,
            'job_id' => $this->job_id,
            'religion_id' => $this->religion_id,
            'education_id' => $this->education_id,
            'created_by_id' => $this->created_by_id,
            'responsible_user_id' => $this->responsible_user_id,


            'currency' => new CurrencyResource($this->whenLoaded('currency')),
            'external_office' => new ExternalOfficeResource($this->whenLoaded('external_office')),
            'internal_office' => new InternalOfficeResource($this->whenLoaded('internal_office')),
            'sponsor' => new SponsorResource($this->whenLoaded('sponsor')),


            'external_office_transactions' => $this->whenLoaded('external_office_transactions'), //set Resource

            'country' => new CountryResource($this->whenLoaded('country')),
            'job' => new JobResource($this->whenLoaded('job')),
            'religion' => new ReligionResource($this->whenLoaded('religion')),
            'education' => new EducationResource($this->whenLoaded('education')),
            'created_by' => new UserResource($this->whenLoaded('created_by')),
            'responsible_user' => new UserResource($this->whenLoaded('responsible_user')),


            'reservation' => new ApplicationReservationResource($this->whenLoaded('reservation')),
            'visa' => new ApplicationVisaResource($this->whenLoaded('visa')),
            'expectedArrival' => new ApplicationExpectedArrivalResource($this->whenLoaded('expectedArrival')),
            'arrival' => new ApplicationArrivalResource($this->whenLoaded('arrival')),
            'deportation' => new ApplicationDeportationResource($this->whenLoaded('deportation')),
            'deliver' => new ApplicationDeliverResource($this->whenLoaded('deliver')),
            'resell' => new ApplicationResellResource($this->whenLoaded('resell')),


            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
