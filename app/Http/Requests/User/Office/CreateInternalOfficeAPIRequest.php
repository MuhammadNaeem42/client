<?php

namespace App\Http\Requests\User\Office;

use App\Helpers\APIRequest;
use App\Models\InternalOffice;

/**
 * @property mixed external_offices_ids
 */
class CreateInternalOfficeAPIRequest extends APIRequest
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
        return $rules;
    }
}
