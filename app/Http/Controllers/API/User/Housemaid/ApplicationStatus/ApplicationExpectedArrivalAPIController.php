<?php

namespace App\Http\Controllers\API\User\Housemaid\ApplicationStatus;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\User\Housemaid\ApplicationStatus\ApplicationExpectedArrival\ExpectedArrivalCreateRequest;
use App\Http\Requests\User\Housemaid\ApplicationStatus\ApplicationExpectedArrival\ExpectedArrivalUpdateRequest;
use App\Http\Resources\User\Housemaid\ApplicationStatus\ApplicationExpectedArrivalResource;
use App\Models\Application;
use App\Models\ApplicationStatus\ApplicationArrival;
use App\Models\ApplicationStatus\ApplicationExpectedArrival;
use App\StateMachines\StatusStateApplication;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class ApplicationExpectedArrivalAPIController extends AppBaseController
{
    /**
     * Display a listing of the resource.
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

        $query = ApplicationExpectedArrival::query()->with(['sponsor', 'created_by', 'application'])->filter()->sorted();

        if ($request->get('skip')) {
              $query->skip($request->get('skip'));
        }
        if ($request->get('skip') && $request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $application_expected = $query->where('application_id', $application_id)->get();

        return $this->sendResponse(
            ApplicationExpectedArrivalResource::collection($application_expected),
            __('lang.api.retrieved', ['model' => __('models/application_expected_arrival.plural')])
        );

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param ExpectedArrivalCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(ExpectedArrivalCreateRequest $request)
    {
        $request_data = collect($request->validated())->except(['created_by_id',  'photo', 'cancellation_date', 'status'])->toArray();
        $application_id = $request->application_id;

        /** @var Application $application */
        $application = Application::with(['expectedArrival'])->find($application_id);
        if ($application->expectedArrival) {
            return $this->sendError(__('models/application_expected_arrival.already_exist'));
        }

        if ($request->has('photo'))
            $request_data['photo'] = uploadImage('expected_arrivals', $request->photo);

        DB::beginTransaction();
        try {
            $arrival = ApplicationExpectedArrival::create($request_data);
            if ($arrival) {
                $application->status()->transitionTo(StatusStateApplication::EXPECTED_ARRIVAL);
            }
            DB::commit();
            return $this->sendResponse(
                new ApplicationExpectedArrivalResource($arrival),
                __('lang.api.saved', ['model' => __('models/expected_arrival')])
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
        /** @var ApplicationExpectedArrival $application_arrival */
        $application_arrival = ApplicationExpectedArrival::with(['sponsor', 'created_by', 'application'])->find($id);

        if (empty($application_arrival)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/application_expected_arrival.singular')])
            );
        }

        return $this->sendResponse(
            new ApplicationExpectedArrivalResource($application_arrival),
            __('lang.api.retrieved', ['model' => __('models/application_visas.singular')])
        );
    }


    /**
     * Update the specified resource in storage.
     * POST /application_visas/{id}
     * @param int $id
     * @param ExpectedArrivalUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, ExpectedArrivalUpdateRequest $request)
    {

        $expected_arrival = ApplicationExpectedArrival::find($id);
        if (empty($expected_arrival)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/expected_arrival')])
            );
        }
        $request_data = collect($request->validated())->except(['photo', '_method', 'created_by_id'])->toArray();

        if ($request->has('photo'))
            $request_data['photo'] = uploadImage('expected_arrivals', $request->photo);


        $expected_arrival->fill($request_data);
        $expected_arrival->save();

        return $this->sendResponse(
            new ApplicationExpectedArrivalResource($expected_arrival),
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
            /** @var ApplicationArrival $application_expected */
            $application_expected = ApplicationExpectedArrival::with('application')->active()->find($id);

            if (empty($application_expected)) {
                return $this->sendError(
                    __('lang.api.not_found', ['model' => __('models/application_expected_arrival.singular')])
                );
            }

            $application_expected->application
                ->status()->transitionTo(
                    $to = StatusStateApplication::VISA,
                    $customProperties = ['comment' => \request('comment')]
                );
            $application_expected->fill(['status' => false, 'cancellation_date' => Carbon::now()->format('Y-m-d')]);
            $application_expected->save();

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
