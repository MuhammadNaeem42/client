<?php

namespace App\Http\Controllers\API\User;


use App\Http\Requests\User\CreateExternalOfficeTransactionAPIRequest;
use App\Http\Requests\User\UpdateExternalOfficeTransactionAPIRequest;
use App\Http\Resources\User\ExternalOfficeTransactionResource;
use App\Models\ExternalOfficeTransaction;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ExternalOfficeTransactionAPIController
 * @package App\Http\Controllers\API\User
 */
class ExternalOfficeTransactionAPIController extends AppBaseController
{
    /**
     * Display a listing of the ExternalOfficeTransaction.
     * GET|HEAD /external_office_transactions
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = ExternalOfficeTransaction::query()->filter()->sorted();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $external_office_transactions = $query->get();

        return $this->sendResponse(
            ExternalOfficeTransactionResource::collection($external_office_transactions),
            __('lang.api.retrieved', ['model' => __('models/external_office_transactions.plural')])
        );
    }


    /**
     * Display the specified ExternalOfficeTransaction.
     * GET|HEAD /external_office_transactions/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var ExternalOfficeTransaction $external_office_transaction */
        $external_office_transaction = ExternalOfficeTransaction::find($id);

        if (empty($external_office_transaction)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/external_office_transactions.singular')])
            );
        }

        return $this->sendResponse(
            new ExternalOfficeTransactionResource($external_office_transaction),
            __('lang.api.retrieved', ['model' => __('models/external_office_transactions.singular')])
        );
    }

    /**
     * Store a newly created ExternalOfficeTransaction in storage.
     *
     * @param CreateExternalOfficeTransactionAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateExternalOfficeTransactionAPIRequest $request)
    {

        $request_data = $request->validated();


        /** @var ExternalOfficeTransaction $external_office_transaction */
        $external_office_transaction = ExternalOfficeTransaction::create($request_data);

        return $this->sendResponse(
            new ExternalOfficeTransactionResource($external_office_transaction),
            __('lang.api.saved', ['model' => __('models/external_office_transactions.singular')])
        );
    }

    /**
     * Update the specified ExternalOfficeTransaction in storage.
     * PUT/PATCH /external_office_transactions/{id}
     *
     * @param int $id
     * @param UpdateExternalOfficeTransactionAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateExternalOfficeTransactionAPIRequest $request)
    {
        /** @var ExternalOfficeTransaction $external_office_transaction */
        $external_office_transaction = ExternalOfficeTransaction::find($id);

        if (empty($external_office_transaction)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/external_office_transactions.singular')])
            );
        }

        $request_data = $request->except(['_method', '_token']);


        $external_office_transaction->fill($request_data);
        $external_office_transaction->save();


        return $this->sendResponse(
            new ExternalOfficeTransactionResource($external_office_transaction),
            __('lang.api.updated', ['model' => __('models/external_office_transactions.singular')])
        );
    }

    /**
     * Remove the specified ExternalOfficeTransaction from storage.
     * DELETE /external_office_transactions/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        /** @var ExternalOfficeTransaction $external_office_transaction */
        $external_office_transaction = ExternalOfficeTransaction::find($id);

        if (empty($external_office_transaction)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/external_office_transactions.singular')])
            );
        }

        try {
            $external_office_transaction->delete();
        } catch (\Exception $exception) {
            return $this->sendError(
                __('lang.api.You_cannot_delete_recoded_model')
            );
        }

        return $this->sendResponse(
            $id,
            __('lang.api.deleted', ['model' => __('models/external_office_transactions.singular')])
        );
    }

}
