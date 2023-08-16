<?php

namespace App\Http\Controllers\API\User\Office;


use App\Http\Requests\User\Office\CreateInternalOfficeAPIRequest;
use App\Http\Requests\User\Office\UpdateInternalOfficeAPIRequest;
use App\Http\Resources\User\Office\InternalOfficeResource;
use App\Models\InternalOffice;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class InternalOfficeAPIController
 * @package App\Http\Controllers\API\User\Office
 */
class InternalOfficeAPIController extends AppBaseController
{
    /**
     * Display a listing of the InternalOffice.
     * GET|HEAD /internal_offices
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = InternalOffice::query()->with(['country','currency'])->filter()->sorted();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $internal_offices = $query->get();

        return $this->sendResponse(
            InternalOfficeResource::collection($internal_offices),
            __('lang.api.retrieved', ['model' => __('models/internal_offices.plural')])
        );
    }


    /**
     * Display the specified InternalOffice.
     * GET|HEAD /internal_offices/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var InternalOffice $internal_office */
        $internal_office = InternalOffice::with(['country','currency','external_offices.country', 'external_offices.currency','bank_info_country','bank_info_currency'])
            ->withCount(['applications','applications_done','applications_cancel'])
            ->find($id);

        if (empty($internal_office)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/internal_offices.singular')])
            );
        }

        return $this->sendResponse(
            new InternalOfficeResource($internal_office),
            __('lang.api.retrieved', ['model' => __('models/internal_offices.singular')])
        );
    }

    /**
     * Store a newly created InternalOffice in storage.
     *
     * @param CreateInternalOfficeAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateInternalOfficeAPIRequest $request)
    {

        $request_data = $request->validated();


        /** @var InternalOffice $internal_office */
        $internal_office = InternalOffice::create($request_data);

        if ($request->has('external_offices_ids'))
            $internal_office->external_offices()->sync($request->external_offices_ids);

        return $this->sendResponse(
            new InternalOfficeResource($internal_office),
            __('lang.api.saved', ['model' => __('models/internal_offices.singular')])
        );
    }

    /**
     * Update the specified InternalOffice in storage.
     * PUT/PATCH /internal_offices/{id}
     *
     * @param int $id
     * @param UpdateInternalOfficeAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateInternalOfficeAPIRequest $request)
    {
        /** @var InternalOffice $internal_office */
        $internal_office = InternalOffice::find($id);

        if (empty($internal_office)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/internal_offices.singular')])
            );
        }

        $request_data = $request->except(['_method', '_token']);


        $internal_office->fill($request_data);
        $internal_office->save();

        if ($request->has('external_offices_ids'))
            $internal_office->external_offices()->sync($request->external_offices_ids);

        return $this->sendResponse(
            new InternalOfficeResource($internal_office),
            __('lang.api.updated', ['model' => __('models/internal_offices.singular')])
        );
    }

    /**
     * Remove the specified InternalOffice from storage.
     * DELETE /internal_offices/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var InternalOffice $internal_office */
        $internal_office = InternalOffice::find($id);

        if (empty($internal_office)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/internal_offices.singular')])
            );
        }

        try {
            $internal_office->delete();
        } catch (\Exception $exception) {
            return $this->sendError(
                __('lang.api.You_cannot_delete_recoded_model')
            );
        }

        return $this->sendResponse(
            $id,
            __('lang.api.deleted', ['model' => __('models/internal_offices.singular')])
        );
    }

    public function generateCode($name)
    {
        $last_id = 1;
        $last_internal_office = InternalOffice::latest()->first();
        $last_id = $last_internal_office ? ($last_internal_office->id + 1) : $last_id;

        $code = getFirstCharFromWords($name);

        do {

            $code = strtoupper($code) . '-' . $last_id;
            $last_id++;
        } while (InternalOffice::where('code', $code)->exists());

        return $this->sendResponse(
            $code,
            __('lang.api.retrieved', ['model' => __('models/internal_offices.singular')])
        );
    }

}
