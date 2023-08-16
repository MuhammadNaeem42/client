<?php

namespace App\Http\Controllers\API\User;


use App\Http\Requests\User\CreateCountryAPIRequest;
use App\Http\Requests\User\UpdateCountryAPIRequest;
use App\Http\Resources\User\CountryResource;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class CountryAPIController
 * @package App\Http\Controllers\API\User
 */
class CountryAPIController extends AppBaseController
{
    /**
     * Display a listing of the Country.
     * GET|HEAD /countries
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Country::query()->filter()->sorted();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $countries = $query->get();

        return $this->sendResponse(
            CountryResource::collection($countries),
            __('lang.api.retrieved', ['model' => __('models/countries.plural')])
        );
    }


    /**
     * Display the specified Country.
     * GET|HEAD /countries/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var Country $country */
        $country = Country::find($id);

        if (empty($country)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/countries.singular')])
            );
        }

        return $this->sendResponse(
            new CountryResource($country),
            __('lang.api.retrieved', ['model' => __('models/countries.singular')])
        );
    }

    /**
     * Store a newly created Country in storage.
     *
     * @param CreateCountryAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateCountryAPIRequest $request)
    {

        $request_data = $request->validated();


        /** @var Country $country */
        $country = Country::create($request_data);

        return $this->sendResponse(
            new CountryResource($country),
            __('lang.api.saved', ['model' => __('models/countries.singular')])
        );
    }

    /**
     * Update the specified Country in storage.
     * PUT/PATCH /countries/{id}
     *
     * @param int $id
     * @param UpdateCountryAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateCountryAPIRequest $request)
    {
        /** @var Country $country */
        $country = Country::find($id);

        if (empty($country)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/countries.singular')])
            );
        }

        $request_data = $request->except(['_method', '_token']);


        $country->fill($request_data);
        $country->save();


        return $this->sendResponse(
            new CountryResource($country),
            __('lang.api.updated', ['model' => __('models/countries.singular')])
        );
    }

    /**
     * Remove the specified Country from storage.
     * DELETE /countries/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var Country $country */
        $country = Country::find($id);

        if (empty($country)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/countries.singular')])
            );
        }

        try {
            $country->delete();
        } catch (\Exception $exception) {
            return $this->sendError(
                __('lang.api.You_cannot_delete_recoded_model')
            );
        }

        return $this->sendResponse(
            $id,
            __('lang.api.deleted', ['model' => __('models/countries.singular')])
        );
    }

}
