<?php

namespace App\Http\Requests\User;

use App\Helpers\APIRequest;
use App\Models\Country;

class UpdateCountryAPIRequest extends APIRequest
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
        $rules = Country::$rules;

        $rules['code'] = $rules['code'] . ",code," . $this->route("country");

        return $rules;
    }
}
