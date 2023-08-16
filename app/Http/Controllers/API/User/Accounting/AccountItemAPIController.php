<?php

namespace App\Http\Controllers\API\User\Accounting;


use App\Http\Requests\User\CreateAccountItemAPIRequest;
use App\Http\Requests\User\UpdateAccountItemAPIRequest;
use App\Http\Resources\User\Accounting\AccountItemResource;
use App\Models\AccountItem;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class AccountItemAPIController
 * @package App\Http\Controllers\API\User\Accounting
 */
class AccountItemAPIController extends AppBaseController
{
    /**
     * Display a listing of the AccountItem.
     * GET|HEAD /account_items
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = AccountItem::query();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $account_items = $query->get();

        return $this->sendResponse(
            AccountItemResource::collection($account_items),
            __('lang.api.retrieved', ['model' => __('models/account_items.plural')])
        );
    }


    /**
     * Display the specified AccountItem.
     * GET|HEAD /account_items/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var AccountItem $account_item */
        $account_item = AccountItem::find($id);

        if (empty($account_item)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/account_items.singular')])
            );
        }

        return $this->sendResponse(
            new AccountItemResource($account_item),
            __('lang.api.retrieved', ['model' => __('models/account_items.singular')])
        );
    }

    /**
     * Store a newly created AccountItem in storage.
     *
     * @param CreateAccountItemAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateAccountItemAPIRequest $request)
    {

        $request_data = $request->validated();


        /** @var AccountItem $account_item */
        $account_item = AccountItem::create($request_data);

        return $this->sendResponse(
            new AccountItemResource($account_item),
            __('lang.api.saved', ['model' => __('models/account_items.singular')])
        );
    }

    /**
     * Update the specified AccountItem in storage.
     * PUT/PATCH /account_items/{id}
     *
     * @param int $id
     * @param UpdateAccountItemAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateAccountItemAPIRequest $request)
    {
        /** @var AccountItem $account_item */
        $account_item = AccountItem::find($id);

        if (empty($account_item)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/account_items.singular')])
            );
        }

        $request_data = $request->except(['_method', '_token']);


        $account_item->fill($request_data);
        $account_item->save();


        return $this->sendResponse(
            new AccountItemResource($account_item),
            __('lang.api.updated', ['model' => __('models/account_items.singular')])
        );
    }

    /**
     * Remove the specified AccountItem from storage.
     * DELETE /account_items/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        /** @var AccountItem $account_item */
        $account_item = AccountItem::find($id);

        if (empty($account_item)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/account_items.singular')])
            );
        }

        try {
            $account_item->delete();
        } catch (\Exception $exception) {
            return $this->sendError(
                __('lang.api.You_cannot_delete_recoded_model')
            );
        }

        return $this->sendResponse(
            $id,
            __('lang.api.deleted', ['model' => __('models/account_items.singular')])
        );
    }

}
