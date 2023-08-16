<?php

namespace App\Http\Controllers\API\User\Accounting;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\User\Accounting\Journal\CreateJournalAPIRequest;
use App\Http\Requests\User\Accounting\Journal\UpdateJournalAPIRequest;
use App\Http\Resources\User\Accounting\JournalResource;
use App\Models\Accounting\Journal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JournalAPIController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {

        $query = Journal::query()->filter()->sorted();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('skip') && $request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $journal = $query->get();

        return $this->sendResponse(
            JournalResource::collection($journal),
            __('lang.api.retrieved', ['model' => __('models/journal.plural')])
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param CreateJournalAPIRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function store(CreateJournalAPIRequest $request): JsonResponse
    {
        $request_date = collect($request->validated())->toArray();
        DB::beginTransaction();
        try {
            $journal = Journal::create($request_date);
            DB::commit();
            return $this->sendResponse(
                new JournalResource($journal),
                __('lang.api.saved', ['model' => __('models/journal.singular')])
            );
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError(
                $exception->getMessage()
            );
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $journal = Journal::find($id);
        if (empty($journal)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/journal.singular')])
            );
        }

        return $this->sendResponse(
            new JournalResource($journal),
            __('lang.api.retrieved', ['model' => __('models/journal.singular')])
        );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateJournalAPIRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateJournalAPIRequest $request, int $id): JsonResponse
    {
        $journal = Journal::find($id);
        if (empty($journal)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/Journal.singular')])
            );
        }
        $request_data = collect($request->validated())->toArray();

        $journal->fill($request_data);
        $journal->save();
        return $this->sendResponse(
            new JournalResource($journal),
            __('lang.api.updated', ['model' => __('models/journal.singular')])
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        /** @var Journal $journal */
        $journal = Journal::find($id);

        if (empty($journal)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/journal.singular')])
            );
        }

        try {
            $journal->delete();
        } catch (\Exception $exception) {
            return $this->sendError(
                __('lang.api.You_cannot_delete_recoded_model')
            );
        }

        return $this->sendResponse(
            $id,
            __('lang.api.deleted', ['model' => __('models/journal.singular')])
        );
    }
}
