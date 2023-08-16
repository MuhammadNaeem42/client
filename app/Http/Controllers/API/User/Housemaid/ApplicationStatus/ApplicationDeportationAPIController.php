<?php

namespace App\Http\Controllers\API\User\Housemaid\ApplicationStatus;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\User\Housemaid\ApplicationStatus\ApplicationDeportation\CreateApplicationDeportationRequest;
use App\Http\Requests\User\Housemaid\ApplicationStatus\ApplicationDeportation\UpdateApplicationDeportationRequest;
use App\Http\Resources\User\Housemaid\ApplicationStatus\ApplicationDeportationResource;
use App\Models\Application;
use App\Models\ApplicationStatus\ApplicationDeportation;
use App\StateMachines\StatusStateApplication;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class ApplicationDeportationAPIController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = ApplicationDeportation::query()->with(['sponsor', 'created_by', 'application'])->filter()->sorted();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }

        if ($request->get('skip') && $request->get('limit')) {
            $query->limit($request->get('limit'));
        }


        $application_deportation = $query->get();

        return $this->sendResponse(
            ApplicationDeportationResource::collection($application_deportation),
            __('lang.api.retrieved', ['model' => __('models/application_deportation.plural')])
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param CreateApplicationDeportationRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(CreateApplicationDeportationRequest $request)
    {
        DB::beginTransaction();
        try {
            $request_data = collect($request->validated())->except(['created_by_id', 'status', 'cancellation_date'])->toArray();

            $application = Application::with(['deportation'])->find($request->application_id);
            if ($application->deportation) {
                return $this->sendError(__('models/application_deportation.already_exist'));
            }


            /** @var ApplicationDeportation $application_deporation */
            $application_deportation = ApplicationDeportation::create($request_data);
            if ($application_deportation) {
                $application->status()->transitionTo(StatusStateApplication::DEPORTATION);
            }

            DB::commit();
            return $this->sendResponse(
                new ApplicationDeportationResource($application_deportation),
                __('lang.api.saved', ['model' => __('models/application_deportation.singular')])
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var ApplicationDeportation $application_deportation */
        $application_deportation = ApplicationDeportation::with(['sponsor', 'created_by', 'application'])->find($id);

        if (empty($application_deportation)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/application_deportation.singular')])
            );
        }

        return $this->sendResponse(
            new ApplicationDeportationResource($application_deportation),
            __('lang.api.retrieved', ['model' => __('models/application_deportation.singular')])
        );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateApplicationDeportationRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateApplicationDeportationRequest $request, $id)
    {
        $application_deportation = ApplicationDeportation::find($id);

        if (empty($application_deportation)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/application_deportation.singular')])
            );
        }

        $request_data = collect($request->validated())->except(['created_by_id', '_method', '_token', 'cancellation_date', 'status'])->toArray();


        $application_deportation->fill($request_data);
        $application_deportation->save();


        return $this->sendResponse(
            new ApplicationDeportationResource($application_deportation),
            __('lang.api.updated', ['model' => __('models/application_deportation.singular')])
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
            /** @var ApplicationDeportation $application_deportation */
            $application_deportation = ApplicationDeportation::with('application')->active()->find($id);

            if (empty($application_deportation)) {
                return $this->sendError(
                    __('lang.api.not_found', ['model' => __('models/application_deportation.singular')])
                );
            }

            $application_deportation->application
                ->status()->transitionTo(
                    $to = StatusStateApplication::ARRIVAL,
                    $customProperties = ['comment' => \request('comment')]
                );

            $application_deportation->fill(['status' => false, 'cancellation_date' => Carbon::now()->format('Y-m-d')]);
            $application_deportation->save();

            DB::commit();
            return $this->sendResponse(
                $id,
                __('lang.api.deleted', ['model' => __('models/application_deportation.singular')])
            );

        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError(
                $exception->getMessage()
            );
        }


    }

}
