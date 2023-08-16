<?php

namespace App\Http\Controllers\API\User\Housemaid\ApplicationStatus;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\User\Housemaid\ApplicationStatus\ApplicationArrival\ArrivalCreateRequest;
use App\Http\Requests\User\Housemaid\ApplicationStatus\ApplicationArrival\ArrivalUpdateRequest;
use App\Http\Resources\User\Housemaid\ApplicationStatus\ApplicationArrivalResource;
use App\Models\Application;
use App\Models\ApplicationStatus\ApplicationArrival;
use App\StateMachines\StatusStateApplication;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class ApplicationArrivalAPIController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {

        $query = ApplicationArrival::query()->with(['sponsor', 'created_by', 'application'])->filter()->sorted();

        if ($request->get('skip')) {
             $query->skip($request->get('skip'));
        }
        if ($request->get('skip') && $request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $application_arrival = $query->get();

        return $this->sendResponse(
            ApplicationArrivalResource::collection($application_arrival),
            __('lang.api.retrieved', ['model' => __('models/application_arrival.plural')])
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param ArrivalCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(ArrivalCreateRequest $request)
    {
        $request_data = collect($request->validated())->except(['created_by_id', 'status', 'photo', 'cancellation_date'])->toArray();
        $application_id = $request->application_id;

        /** @var Application $application */
        $application = Application::find($application_id);
        if ($application->arrival) {
            return $this->sendError(__('models/application_arrival.already_exist'));
        }

        DB::beginTransaction();

        try {
            $arrival = ApplicationArrival::create($request_data);
            if ($arrival) {
                $application->status()->transitionTo(StatusStateApplication::ARRIVAL);
            }
            DB::commit();
            return $this->sendResponse(
                new ApplicationArrivalResource($arrival),
                __('lang.api.saved', ['model' => __('models/arrival')])
            );
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError(
                $exception->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var ApplicationArrival $application_arrival */
        $application_arrival = ApplicationArrival::with(['sponsor', 'created_by', 'application'])->find($id);

        if (empty($application_arrival)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/application_arrival.singular')])
            );
        }

        return $this->sendResponse(
            new ApplicationArrivalResource($application_arrival),
            __('lang.api.retrieved', ['model' => __('models/application_arrival.singular')])
        );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param ArrivalUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ArrivalUpdateRequest $request, $id)
    {
        $arrival = ApplicationArrival::find($id);
        if (empty($arrival)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/arrival')])
            );
        }
        $request_data = collect($request->validated())->except(['created_by_id', '_method', '_token', 'photo', 'cancellation_date', 'status'])->toArray();


        $arrival->fill($request_data);
        $arrival->save();

        return $this->sendResponse(
            new ApplicationArrivalResource($arrival),
            __('lang.api.updated', ['model' => __('models/expected_arrival')])
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            /** @var ApplicationArrival $application_arrival */
            $application_arrival = ApplicationArrival::with('application')->active()->find($id);

            if (empty($application_arrival)) {
                return $this->sendError(
                    __('lang.api.not_found', ['model' => __('models/application_expected_arrival.singular')])
                );
            }

            $application_arrival->application
                ->status()->transitionTo(
                    $to = StatusStateApplication::EXPECTED_ARRIVAL,
                    $customProperties = ['comment' => \request('comment')]
                );
            $application_arrival->fill(['status' => false, 'cancellation_date' => Carbon::now()->format('Y-m-d')]);
            $application_arrival->save();

            DB::commit();
            return $this->sendResponse(
                $id,
                __('lang.api.deleted', ['model' => __('models/application_expected_arrival.singular')])
            );

        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError(
                $exception->getMessage()
            );
        }
    }
}
