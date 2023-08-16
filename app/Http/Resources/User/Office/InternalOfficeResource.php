<?php

namespace App\Http\Resources\User\Office;

use App\Http\Resources\User\Accounting\CurrencyResource;
use App\Http\Resources\User\CountryResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class InternalOfficeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        $statistics = $this->getStatistics();
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name_en' => $this->name_en,
            'name_ar' => $this->name_ar,
            'address_en' => $this->address_en,
            'address_ar' => $this->address_ar,
            'phone' => $this->phone,
            'registration_number' => $this->registration_number,
            'num_ministry_commerce' => $this->num_ministry_commerce,
            'manpower' => $this->manpower,
            'country_id' => $this->country_id,
            'currency_id' => $this->currency_id,
            'external_offices' => ExternalOfficeResource::collection($this->whenLoaded('external_offices')),
            'country' => new CountryResource($this->whenLoaded('country')),
            'currency' => new CurrencyResource($this->whenLoaded('currency')),

            ##start bank info ##
            'bank_info_name' => $this->bank_info_name,
            'bank_info_company_name' => $this->bank_info_company_name,
            'bank_info_beneficiary_name' => $this->bank_info_beneficiary_name,
            'bank_info_swift_code' => $this->bank_info_swift_code,
            'bank_info_iban' => $this->bank_info_iban,
            'bank_info_account_number' => $this->bank_info_account_number,
            'bank_info_phone' => $this->bank_info_phone,
            'bank_info_country_id' => $this->bank_info_country_id,
            'bank_info_currency_id' => $this->bank_info_currency_id,
            'bank_info_country' => new CountryResource($this->whenLoaded('bank_info_country')),
            'bank_info_currency' => new CurrencyResource($this->whenLoaded('bank_info_currency')),
            ##End bank info ##

            'statistics' => $statistics,
            'balance' => 100, // from accounting TODO implement balance credit from accounting

            'applications_count' => $this->when(isset($this->applications_count), $this->applications_count),
            'applications_done_count' => $this->when(isset($this->applications_done_count), $this->applications_done_count),
            'applications_cancel_count' => $this->when(isset($this->applications_cancel_count), $this->applications_cancel_count),


            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
