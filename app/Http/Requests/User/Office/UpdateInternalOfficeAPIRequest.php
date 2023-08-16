<?php

namespace App\Http\Requests\User\Office;

use App\Helpers\APIRequest;
use App\Models\InternalOffice;

class UpdateInternalOfficeAPIRequest extends APIRequest
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
        $rules = InternalOffice::$rules;

        $rules['code'] = $rules['code'] . ",code," . $this->route("internal_office");
        $rules['registration_number'] = $rules['registration_number'] . ",registration_number," . $this->route("internal_office");
        return $rules;
    }
}
