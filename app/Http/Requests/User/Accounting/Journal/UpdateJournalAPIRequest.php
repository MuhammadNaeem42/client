<?php

namespace App\Http\Requests\User\Accounting\Journal;


use App\Helpers\APIRequest;
use App\Models\Accounting\Journal;

class UpdateJournalAPIRequest extends APIRequest
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

        $rules = Journal::$rules;
        $rules['code'] = $rules['code'] . ",code," . $this->route("journal");

        return $rules;
    }
}
