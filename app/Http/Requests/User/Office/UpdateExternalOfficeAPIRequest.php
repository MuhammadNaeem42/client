<?php

namespace App\Http\Requests\User\Office;

use App\Helpers\APIRequest;
use App\Models\ExternalOffice;

class UpdateExternalOfficeAPIRequest extends APIRequest
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
        $rules = ExternalOffice::$rules;

        $rules['code'] = $rules['code'] . ",code," . $this->route("external_office");
        return $rules;
    }
}
