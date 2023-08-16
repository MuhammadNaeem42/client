<?php

namespace App\Http\Controllers\API\User;


use App\Http\Requests\User\CreateEducationAPIRequest;
use App\Http\Requests\User\UpdateEducationAPIRequest;
use App\Http\Resources\User\EducationResource;
use App\Models\Education;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class EducationAPIController
 * @package App\Http\Controllers\API\User
 */
class EducationAPIController extends AppBaseController
{
    /**
     * Display a listing of the Education.
     * GET|HEAD /educations
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Education::query()->filter()->sorted();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $educations = $query->get();

        return $this->sendResponse(
            EducationResource::collection($educations),
            __('lang.api.retrieved', ['model' => __('models/educations.plural')])
        );
    }


    /**
     * Display the specified Education.
     * GET|HEAD /educations/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var Education $education */
        $education = Education::find($id);

        if (empty($education)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/educations.singular')])
            );
        }

        return $this->sendResponse(
            new EducationResource($education),
            __('lang.api.retrieved', ['model' => __('models/educations.singular')])
        );
    }

    /**
     * Store a newly created Education in storage.
     *
     * @param CreateEducationAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateEducationAPIRequest $request)
    {

        $request_data = $request->validated();


        /** @var Education $education */
        $education = Education::create($request_data);

        return $this->sendResponse(
            new EducationResource($education),
            __('lang.api.saved', ['model' => __('models/educations.singular')])
        );
    }

    /**
     * Update the specified Education in storage.
     * PUT/PATCH /educations/{id}
     *
     * @param int $id
     * @param UpdateEducationAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateEducationAPIRequest $request)
    {
        /** @var Education $education */
        $education = Education::find($id);

        if (empty($education)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/educations.singular')])
            );
        }

        $request_data = $request->except(['_method', '_token']);


        $education->fill($request_data);
        $education->save();


        return $this->sendResponse(
            new EducationResource($education),
            __('lang.api.updated', ['model' => __('models/educations.singular')])
        );
    }

    /**
     * Remove the specified Education from storage.
     * DELETE /educations/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var Education $education */
        $education = Education::find($id);

        if (empty($education)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/educations.singular')])
            );
        }

        try {
            $education->delete();
        } catch (\Exception $exception) {
            return $this->sendError(
                __('lang.api.You_cannot_delete_recoded_model')
            );
        }

        return $this->sendResponse(
            $id,
            __('lang.api.deleted', ['model' => __('models/educations.singular')])
        );
    }

}
