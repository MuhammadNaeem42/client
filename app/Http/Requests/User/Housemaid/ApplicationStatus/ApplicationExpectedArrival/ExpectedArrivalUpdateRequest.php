<?php

namespace App\Http\Requests\User\Housemaid\ApplicationStatus\ApplicationExpectedArrival;

use App\Helpers\APIRequest;
use App\Models\ApplicationStatus\ApplicationExpectedArrival;

class ExpectedArrivalUpdateRequest extends APIRequest
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
        $rules = ApplicationExpectedArrival::$rules;
        return $rules;
    }
}
