<?php

namespace App\Http\Resources\User;

use App\Http\Resources\User\Office\ExternalOfficeResource;
use App\Http\Resources\User\Office\InternalOfficeResource;
use App\Models\ExternalOffice;
use App\Models\InternalOffice;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $office = null;

        if ($this->type == User::$USER_TYPE_EXTERNAL_OFFICE)
            $office = new ExternalOfficeResource(ExternalOffice::find($this->model_id));
        elseif ($this->type == User::$USER_TYPE_INTERNAL_OFFICE)
            $office = new InternalOfficeResource(InternalOffice::find($this->model_id));


//        $all_permissions = getAllPermissions();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'photo' => $this->photo,
            'type' => $this->type,
            'role' => $this->role,
            'model_id' => $this->model_id,
            'office' => $office,
            'device_token' => $this->device_token,
//            'is_active' => $this->is_active,
            'status' => $this->is_active,
//            'all_permissions' =>$this->id==1?$all_permissions['all_permission_format']: $this->all_permissions,
//            'current_permissions' => $this->id==1?$all_permissions['all_permission']:$this->current_permissions,
            'all_permissions' => $this->all_permissions,
            'current_permissions' => $this->current_permissions,

            'signature' => $this->signature,


            'country_id' => $this->country_id,
            'language_id' => $this->language_id,
            'country' => new CountryResource($this->whenLoaded('country')),
            'language' => new LanguageResource($this->whenLoaded('language')),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
