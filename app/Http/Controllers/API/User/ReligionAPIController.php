<?php

namespace App\Http\Controllers\API\User;


use App\Http\Requests\User\CreateReligionAPIRequest;
use App\Http\Requests\User\UpdateReligionAPIRequest;
use App\Http\Resources\User\ReligionResource;
use App\Models\Religion;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ReligionAPIController
 * @package App\Http\Controllers\API\User
 */
class ReligionAPIController extends AppBaseController
{
    /**
     * Display a listing of the Religion.
     * GET|HEAD /religions
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Religion::query()->filter()->sorted();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $religions = $query->get();

        return $this->sendResponse(
            ReligionResource::collection($religions),
            __('lang.api.retrieved', ['model' => __('models/religions.plural')])
        );
    }


    /**
     * Display the specified Religion.
     * GET|HEAD /religions/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var Religion $religion */
        $religion = Religion::find($id);

        if (empty($religion)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/religions.singular')])
            );
        }

        return $this->sendResponse(
            new ReligionResource($religion),
            __('lang.api.retrieved', ['model' => __('models/religions.singular')])
        );
    }

    /**
     * Store a newly created Religion in storage.
     *
     * @param CreateReligionAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateReligionAPIRequest $request)
    {

        $request_data = $request->validated();


        /** @var Religion $religion */
        $religion = Religion::create($request_data);

        return $this->sendResponse(
            new ReligionResource($religion),
            __('lang.api.saved', ['model' => __('models/religions.singular')])
        );
    }

    /**
     * Update the specified Religion in storage.
     * PUT/PATCH /religions/{id}
     *
     * @param int $id
     * @param UpdateReligionAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateReligionAPIRequest $request)
    {
        /** @var Religion $religion */
        $religion = Religion::find($id);

        if (empty($religion)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/religions.singular')])
            );
        }

        $request_data = $request->except(['_method', '_token']);


        $religion->fill($request_data);
        $religion->save();


        return $this->sendResponse(
            new ReligionResource($religion),
            __('lang.api.updated', ['model' => __('models/religions.singular')])
        );
    }

    /**
     * Remove the specified Religion from storage.
     * DELETE /religions/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        /** @var Religion $religion */
        $religion = Religion::find($id);

        if (empty($religion)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/religions.singular')])
            );
        }

        try {
            $religion->delete();
        } catch (\Exception $exception) {
            return $this->sendError(
                __('lang.api.You_cannot_delete_recoded_model')
            );
        }

        return $this->sendResponse(
            $id,
            __('lang.api.deleted', ['model' => __('models/religions.singular')])
        );
    }

}
