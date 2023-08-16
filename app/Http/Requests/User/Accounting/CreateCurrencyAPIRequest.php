<?php

namespace App\Http\Requests\User\Accounting;

use App\Helpers\APIRequest;
use App\Models\Currency;

class CreateCurrencyAPIRequest extends APIRequest
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
        $rules = Currency::$rules;
        return $rules;
    }
}
