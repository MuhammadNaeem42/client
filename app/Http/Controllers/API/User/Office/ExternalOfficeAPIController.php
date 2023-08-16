<?php

namespace App\Http\Controllers\API\User\Office;


use App\Http\Requests\User\Office\CreateExternalOfficeAPIRequest;
use App\Http\Requests\User\Office\UpdateExternalOfficeAPIRequest;
use App\Http\Resources\User\Office\ExternalOfficeResource;
use App\Models\ExternalOffice;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class ExternalOfficeAPIController
 * @package App\Http\Controllers\API\User
 */
class ExternalOfficeAPIController extends AppBaseController
{
    /**
     * Display a listing of the ExternalOffice.
     * GET|HEAD /external_offices
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = ExternalOffice::query()->with(['country','currency'])->filter()->sorted();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $external_offices = $query->get();

        return $this->sendResponse(
            ExternalOfficeResource::collection($external_offices),
            __('lang.api.retrieved', ['model' => __('models/external_offices.plural')])
        );
    }


    /**
     * Display the specified ExternalOffice.
     * GET|HEAD /external_offices/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var ExternalOffice $external_office */
        $external_office = ExternalOffice::with(['country','currency','internal_offices','bank_info_country','bank_info_currency'])
            ->withCount(['applications','applications_done','applications_cancel'])->find($id);

        if (empty($external_office)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/external_offices.singular')])
            );
        }

        return $this->sendResponse(
            new ExternalOfficeResource($external_office),
            __('lang.api.retrieved', ['model' => __('models/external_offices.singular')])
        );
    }

    /**
     * Store a newly created ExternalOffice in storage.
     *
     * @param CreateExternalOfficeAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateExternalOfficeAPIRequest $request)
    {

        $request_data = $request->validated();


        /** @var ExternalOffice $external_office */
        $external_office = ExternalOffice::create($request_data);

        return $this->sendResponse(
            new ExternalOfficeResource($external_office),
            __('lang.api.saved', ['model' => __('models/external_offices.singular')])
        );
    }

    /**
     * Update the specified ExternalOffice in storage.
     * PUT/PATCH /external_offices/{id}
     *
     * @param int $id
     * @param UpdateExternalOfficeAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateExternalOfficeAPIRequest $request)
    {
        /** @var ExternalOffice $external_office */
        $external_office = ExternalOffice::with(['country','currency'])->find($id);

        if (empty($external_office)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/external_offices.singular')])
            );
        }

        $request_data = $request->except(['_method', '_token']);


        $external_office->fill($request_data);
        $external_office->save();


        return $this->sendResponse(
            new ExternalOfficeResource($external_office),
            __('lang.api.updated', ['model' => __('models/external_offices.singular')])
        );
    }

    /**
     * Remove the specified ExternalOffice from storage.
     * DELETE /external_offices/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var ExternalOffice $external_office */
        $external_office = ExternalOffice::find($id);

        if (empty($external_office)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/external_offices.singular')])
            );
        }

        try {
            $external_office->delete();
        } catch (\Exception $exception) {
            return $this->sendError(
                __('lang.api.You_cannot_delete_recoded_model')
            );
        }

        return $this->sendResponse(
            $id,
            __('lang.api.deleted', ['model' => __('models/external_offices.singular')])
        );
    }

    public function generateCode($name)
    {
        $last_id = 1;
        $last_external_office = ExternalOffice::latest()->first();
        $last_id = $last_external_office ? ($last_external_office->id + 1) : $last_id;

        $code = getFirstCharFromWords($name);

        do {

            $code = strtoupper($code) . '-' . $last_id;
            $last_id++;
        } while (ExternalOffice::where('code', $code)->exists());

        return $this->sendResponse(
            $code,
            __('lang.api.retrieved', ['model' => __('models/external_offices.singular')])
        );
    }

}
