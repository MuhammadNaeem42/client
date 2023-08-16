<?php

namespace App\Http\Requests\User;

use App\Helpers\APIRequest;
use App\Models\Sponsor;

class UpdateSponsorAPIRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = Sponsor::$rules;

        $rules['civil_id'] = $rules['civil_id'] . ",civil_id," . $this->route("sponsor");
        $rules['email'] = $rules['email'] . ",email," . $this->route("sponsor");
        $rules['mobile'] = $rules['mobile'] . ",mobile," . $this->route("sponsor");

        return $rules;
    }
}
