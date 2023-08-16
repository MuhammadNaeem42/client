<?php

namespace App\Http\Requests\User\Housemaid\ApplicationStatus\ApplicationDeportation;

use App\Models\ApplicationStatus\ApplicationDeportation;
use Illuminate\Foundation\Http\FormRequest;

class UpdateApplicationDeportationRequest extends FormRequest
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

        $rules = ApplicationDeportation::$rules;
        return $rules;
    }
}
