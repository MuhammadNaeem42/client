<?php

namespace App\Http\Controllers\API\User\Accounting;


use App\Http\Requests\User\Accounting\CreateCurrencyAPIRequest;
use App\Http\Requests\User\Accounting\UpdateCurrencyAPIRequest;
use App\Http\Resources\User\Accounting\CurrencyResource;
use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class CurrencyAPIController
 * @package App\Http\Controllers\API\User\Accounting
 */
class CurrencyAPIController extends AppBaseController
{
    /**
     * Display a listing of the Currency.
     * GET|HEAD /currencies
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Currency::query()->filter()->sorted();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('skip') && $request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $currencies = $query->get();

        return $this->sendResponse(
            CurrencyResource::collection($currencies),
            __('lang.api.retrieved', ['model' => __('models/currencies.plural')])
        );
    }


    /**
     * Display the specified Currency.
     * GET|HEAD /currencies/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var Currency $currency */
        $currency = Currency::find($id);

        if (empty($currency)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/currencies.singular')])
            );
        }

        return $this->sendResponse(
            new CurrencyResource($currency),
            __('lang.api.retrieved', ['model' => __('models/currencies.singular')])
        );
    }

    /**
     * Store a newly created Currency in storage.
     *
     * @param CreateCurrencyAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateCurrencyAPIRequest $request)
    {

        $request_data = $request->validated();


        /** @var Currency $currency */
        $currency = Currency::create($request_data);

        return $this->sendResponse(
            new CurrencyResource($currency),
            __('lang.api.saved', ['model' => __('models/currencies.singular')])
        );
    }

    /**
     * Update the specified Currency in storage.
     * PUT/PATCH /currencies/{id}
     *
     * @param int $id
     * @param UpdateCurrencyAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateCurrencyAPIRequest $request)
    {
        /** @var Currency $currency */
        $currency = Currency::find($id);

        if (empty($currency)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/currencies.singular')])
            );
        }

        $request_data = $request->except(['_method', '_token']);


        $currency->fill($request_data);
        $currency->save();


        return $this->sendResponse(
            new CurrencyResource($currency),
            __('lang.api.updated', ['model' => __('models/currencies.singular')])
        );
    }

    /**
     * Remove the specified Currency from storage.
     * DELETE /currencies/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var Currency $currency */
        $currency = Currency::find($id);

        if (empty($currency)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/currencies.singular')])
            );
        }

        try {
            $currency->delete();
        } catch (\Exception $exception) {
            return $this->sendError(
                __('lang.api.You_cannot_delete_recoded_model')
            );
        }

        return $this->sendResponse(
            $id,
            __('lang.api.deleted', ['model' => __('models/currencies.singular')])
        );
    }

}
