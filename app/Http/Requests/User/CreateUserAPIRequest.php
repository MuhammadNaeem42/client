<?php

namespace App\Http\Requests\User;

use App\Helpers\APIRequest;
use App\Models\User;

class CreateUserAPIRequest extends APIRequest
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
        $rules = User::$rules;
        return $rules;
    }
}
