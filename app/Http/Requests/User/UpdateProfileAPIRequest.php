<?php

namespace App\Http\Requests\User;

use App\Helpers\APIRequest;
use App\Models\User;

class UpdateProfileAPIRequest extends APIRequest
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
        $rules = collect(User::$rules)->only(['name','email','mobile'])->toArray();

        $rules['email'] = $rules['email'] . ",email," . $this->user()->id;
        $rules['mobile'] = '';
        $rules['password'] = '';

        return $rules;
    }
}
