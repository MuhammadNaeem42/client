<?php

namespace App\Http\Requests\User\Housemaid\ApplicationStatus\ApplicationArrival;

use App\Helpers\APIRequest;
use App\Models\ApplicationStatus\ApplicationArrival;

class ArrivalCreateRequest extends APIRequest
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
        $rules =  ApplicationArrival::$rules;
        return $rules;
    }
}
