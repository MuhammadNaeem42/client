<?php

namespace App\Http\Controllers\API\User\Housemaid\ApplicationStatus;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\User\Housemaid\ApplicationStatus\ApplicationDeliver\CreateApplicationDeliverRequest;
use App\Http\Requests\User\Housemaid\ApplicationStatus\ApplicationDeliver\UpdateApplicationDeliverRequest;
use App\Http\Resources\User\Housemaid\ApplicationStatus\ApplicationDeliverResource;
use App\Models\Application;
use App\Models\ApplicationStatus\ApplicationDeliver;
use App\StateMachines\StatusStateApplication;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class ApplicationDeliverAPIController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {

        $query = Applicationdeliver::query()->with(['sponsor', 'created_by', 'application'])->filter()->sorted();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $application_delivers = $query->get();

        return $this->sendResponse(
            ApplicationDeliverResource::collection($application_delivers),
            __('lang.api.retrieved', ['model' => __('models/application_delivers.plural')])
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateApplicationDeliverRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(CreateApplicationDeliverRequest $request)
    {
        DB::beginTransaction();
        try {
            $request_data = collect($request->validated())->except(['created_by_id', 'status', 'cancellation_date'])->toArray();

            $application = Application::with(['deliver'])->find($request->application_id);
            if ($application->deliver) {
                return $this->sendError(__('models/application_deliver.already_exist'));
            }

            /** @var ApplicationDeliver $application_deliver */
            $application_deliver = ApplicationDeliver::create($request_data);
            if ($application_deliver) {
                if ($request->pay_status == 'paid_full')
                    $application->status()->transitionTo(StatusStateApplication::DELIVER_PAID_FULL);
                else
                    $application->status()->transitionTo(StatusStateApplication::DELIVER_PAID_PARTIAL);
            }

            DB::commit();
            return $this->sendResponse(
                new ApplicationDeliverResource($application_deliver),
                __('lang.api.saved', ['model' => __('models/application_deliver.singular')])
            );
        } catch (\Exception $exception) {
            DB::rollBack();

            return $this->sendError(
                $exception->getMessage()
            );
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {

        /** @var Applicationdeliver $application_deliver */
        $application_deliver = ApplicationDeliver::with(['sponsor', 'created_by', 'application'])->find($id);

        if (empty($application_deliver)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/application_deliver.singular')])
            );
        }

        return $this->sendResponse(
            new ApplicationDeliverResource($application_deliver),
            __('lang.api.retrieved', ['model' => __('models/application_deliver.singular')])
        );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateApplicationDeliverRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateApplicationDeliverRequest $request, $id)
    {
        /** @var ApplicationDeliver $application_deliver */
        $application_deliver = ApplicationDeliver::find($id);

        if (empty($application_deliver)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/application_deliver.singular')])
            );
        }

        $request_data = collect($request->validated())->except(['created_by_id', '_method', '_token', 'cancellation_date', 'status'])->toArray();

        $application_deliver->fill($request_data);
        $application_deliver->save();


        return $this->sendResponse(
            new ApplicationDeliverResource($application_deliver),
            __('lang.api.updated', ['model' => __('models/application_deliver.singular')])
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            /** @var ApplicationDeliver $application_deliver */
            $application_deliver = ApplicationDeliver::with('application')->active()->find($id);

            if (empty($application_deliver)) {
                return $this->sendError(
                    __('lang.api.not_found', ['model' => __('models/application_deliver.singular')])
                );
            }
            $application_deliver->application
                ->status()->transitionTo(
                    $to = StatusStateApplication::ARRIVAL,
                    $customProperties = ['comment' => \request('comment')]
                );

            $application_deliver->fill(['status' => false, 'cancellation_date' => Carbon::now()->format('Y-m-d')]);
            $application_deliver->save();

            DB::commit();
            return $this->sendResponse(
                $id,
                __('lang.api.deleted', ['model' => __('models/application_deliver.singular')])
            );

        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError(
                $exception->getMessage()
            );
        }

    }
}
