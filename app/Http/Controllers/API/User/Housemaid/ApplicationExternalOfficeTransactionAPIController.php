<?php

namespace App\Http\Controllers\API\User\Housemaid;


use App\Http\Requests\User\Housemaid\CreateApplicationExternalOfficeTransactionAPIRequest;
use App\Http\Requests\User\Housemaid\UpdateApplicationExternalOfficeTransactionAPIRequest;
use App\Http\Resources\User\Housemaid\ApplicationExternalOfficeTransactionResource;
use App\Models\Application;
use App\Models\ApplicationExternalOfficeTransaction;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class ApplicationExternalOfficeTransactionAPIController
 * @package App\Http\Controllers\API\User\Housemaid
 */
class ApplicationExternalOfficeTransactionAPIController extends AppBaseController
{
    /**
     * Display a listing of the ApplicationExternalOfficeTransaction.
     * GET|HEAD /application_external_office_transactions
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {

        $application_id = $request->application_id;
        /** @var Application $application */
        $application = Application::find($application_id);

        if (empty($application)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/applications.singular')])
            );
        }

        $query = ApplicationExternalOfficeTransaction::query();


        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $application_external_office_transactions = $query->where('application_id', $application_id)->get();

        return $this->sendResponse(
            ApplicationExternalOfficeTransactionResource::collection($application_external_office_transactions),
            __('lang.api.retrieved', ['model' => __('models/application_external_office_transactions.plural')])
        );
    }


    /**
     * Display the specified ApplicationExternalOfficeTransaction.
     * GET|HEAD /application_external_office_transactions/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var ApplicationExternalOfficeTransaction $application_external_office_transaction */
        $application_external_office_transaction = ApplicationExternalOfficeTransaction::with(['external_office_transaction','application'])->find($id);

        if (empty($application_external_office_transaction)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/application_external_office_transactions.singular')])
            );
        }

        return $this->sendResponse(
            new ApplicationExternalOfficeTransactionResource($application_external_office_transaction),
            __('lang.api.retrieved', ['model' => __('models/application_external_office_transactions.singular')])
        );
    }

    /**
     * Store a newly created ApplicationExternalOfficeTransaction in storage.
     *
     * @param CreateApplicationExternalOfficeTransactionAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateApplicationExternalOfficeTransactionAPIRequest $request)
    {

        $request_data = $request->validated();


        /** @var ApplicationExternalOfficeTransaction $application_external_office_transaction */
        $application_external_office_transaction = ApplicationExternalOfficeTransaction::create($request_data);

        return $this->sendResponse(
            new ApplicationExternalOfficeTransactionResource($application_external_office_transaction),
            __('lang.api.saved', ['model' => __('models/application_external_office_transactions.singular')])
        );
    }

    /**
     * Update the specified ApplicationExternalOfficeTransaction in storage.
     * PUT/PATCH /application_external_office_transactions/{id}
     *
     * @param int $id
     * @param UpdateApplicationExternalOfficeTransactionAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateApplicationExternalOfficeTransactionAPIRequest $request)
    {
        /** @var ApplicationExternalOfficeTransaction $application_external_office_transaction */
        $application_external_office_transaction = ApplicationExternalOfficeTransaction::find($id);

        if (empty($application_external_office_transaction)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/application_external_office_transactions.singular')])
            );
        }

        $request_data = $request->except(['_method', '_token']);


        $application_external_office_transaction->fill($request_data);
        $application_external_office_transaction->save();


        return $this->sendResponse(
            new ApplicationExternalOfficeTransactionResource($application_external_office_transaction),
            __('lang.api.updated', ['model' => __('models/application_external_office_transactions.singular')])
        );
    }

    /**
     * Remove the specified ApplicationExternalOfficeTransaction from storage.
     * DELETE /application_external_office_transactions/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var ApplicationExternalOfficeTransaction $application_external_office_transaction */
        $application_external_office_transaction = ApplicationExternalOfficeTransaction::find($id);

        if (empty($application_external_office_transaction)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/application_external_office_transactions.singular')])
            );
        }

        try {
            $application_external_office_transaction->delete();
        } catch (\Exception $exception) {
            return $this->sendError(
                __('lang.api.You_cannot_delete_recoded_model')
            );
        }

        return $this->sendResponse(
            $id,
            __('lang.api.deleted', ['model' => __('models/application_external_office_transactions.singular')])
        );
    }

}
