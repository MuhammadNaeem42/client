<?php

namespace App\Http\Controllers\API\User;


use App\Http\Requests\User\CreateLanguageAPIRequest;
use App\Http\Requests\User\UpdateLanguageAPIRequest;
use App\Http\Resources\User\LanguageResource;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class LanguageAPIController
 * @package App\Http\Controllers\API\User
 */
class LanguageAPIController extends AppBaseController
{
    /**
     * Display a listing of the Language.
     * GET|HEAD /languages
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Language::query()->filter()->sorted();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('skip') && $request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $languages = $query->get();

        return $this->sendResponse(
            LanguageResource::collection($languages),
            __('lang.api.retrieved', ['model' => __('models/languages.plural')])
        );
    }


    /**
     * Display the specified Language.
     * GET|HEAD /languages/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var Language $language */
        $language = Language::find($id);

        if (empty($language)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/languages.singular')])
            );
        }

        return $this->sendResponse(
            new LanguageResource($language),
            __('lang.api.retrieved', ['model' => __('models/languages.singular')])
        );
    }

    /**
     * Store a newly created Language in storage.
     *
     * @param CreateLanguageAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateLanguageAPIRequest $request)
    {

        $request_data = $request->validated();


        /** @var Language $language */
        $language = Language::create($request_data);

        return $this->sendResponse(
            new LanguageResource($language),
            __('lang.api.saved', ['model' => __('models/languages.singular')])
        );
    }

    /**
     * Update the specified Language in storage.
     * PUT/PATCH /languages/{id}
     *
     * @param int $id
     * @param UpdateLanguageAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateLanguageAPIRequest $request)
    {
        /** @var Language $language */
        $language = Language::find($id);

        if (empty($language)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/languages.singular')])
            );
        }

        $request_data = $request->except(['_method', '_token']);


        $language->fill($request_data);
        $language->save();


        return $this->sendResponse(
            new LanguageResource($language),
            __('lang.api.updated', ['model' => __('models/languages.singular')])
        );
    }

    /**
     * Remove the specified Language from storage.
     * DELETE /languages/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var Language $language */
        $language = Language::find($id);

        if (empty($language)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/languages.singular')])
            );
        }

        try {
            $language->delete();
        } catch (\Exception $exception) {
            return $this->sendError(
                __('lang.api.You_cannot_delete_recoded_model')
            );
        }

        return $this->sendResponse(
            $id,
            __('lang.api.deleted', ['model' => __('models/languages.singular')])
        );
    }

}
