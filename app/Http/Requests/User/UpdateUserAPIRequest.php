<?php

namespace App\Http\Requests\User;

use App\Helpers\APIRequest;
use App\Models\User;

class UpdateUserAPIRequest extends APIRequest
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

        $rules['email'] = $rules['email'] . ",email," . $this->route("admin");
        $rules['mobile'] = $rules['mobile'] . ",mobile," . $this->route("admin");
        $rules['password'] = '';

        return $rules;
    }
}
