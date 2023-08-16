<?php

namespace App\Http\Controllers\API\User\Housemaid\ApplicationStatus;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\User\Housemaid\ApplicationStatus\ApplicationReSell\CreateApplicationResellRequest;
use App\Http\Requests\User\Housemaid\ApplicationStatus\ApplicationReSell\UpdateApplicationResellRequest;
use App\Http\Resources\User\Housemaid\ApplicationStatus\ApplicationResellResource;
use App\Models\Application;
use App\Models\ApplicationStatus\ApplicationResell;
use App\StateMachines\StatusStateApplication;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class ApplicationResellAPIController extends AppBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {


        $query = ApplicationResell::query()->with(['sponsor', 'created_by', 'application'])->filter()->sorted();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $application_resells = $query->get();

        return $this->sendResponse(
            ApplicationResellResource::collection($application_resells),
            __('lang.api.retrieved', ['model' => __('models/application_resells.plural')])
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param CreateApplicationResellRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateApplicationResellRequest $request)
    {
        DB::beginTransaction();
        try {
            $request_data = collect($request->validated())->except(['created_by_id', 'status', 'cancellation_date'])->toArray();

            $application = Application::with(['resell'])->find($request->application_id);
            if ($application->resell) {
                return $this->sendError(__('models/application_resell.already_exist'));
            }


            /** @var ApplicationResell $application_resell */
            $application_resell = ApplicationResell::create($request_data);
            if ($application_resell) {
                $application->status()->transitionTo(StatusStateApplication::RESELL);
            }

            DB::commit();
            return $this->sendResponse(
                new ApplicationResellResource($application_resell),
                __('lang.api.saved', ['model' => __('models/application_resell.singular')])
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
        /** @var Applicationresell $application_resell */
        $application_resell = ApplicationResell::with(['sponsor', 'created_by', 'application'])->find($id);

        if (empty($application_resell)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/application_resells.singular')])
            );
        }

        return $this->sendResponse(
            new ApplicationresellResource($application_resell),
            __('lang.api.retrieved', ['model' => __('models/application_resells.singular')])
        );
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateApplicationResellRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateApplicationResellRequest $request, $id)
    {
        /** @var Applicationresell $application_resell */
        $application_resell = ApplicationResell::find($id);

        if (empty($application_resell)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/application_resells.singular')])
            );
        }

        $request_data = collect($request->validated())->except(['created_by_id', '_method', '_token', 'cancellation_date', 'status'])->toArray();


        $application_resell->fill($request_data);
        $application_resell->save();

        return $this->sendResponse(
            new ApplicationresellResource($application_resell),
            __('lang.api.updated', ['model' => __('models/application_resells.singular')])
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
            /** @var Applicationresell $application_resell */
            $application_resell = ApplicationResell::with('application')->active()->find($id);

            if (empty($application_resell)) {
                return $this->sendError(
                    __('lang.api.not_found', ['model' => __('models/application_resells.singular')])
                );
            }

            $application_resell->application
                ->status()->transitionTo(
                    $to = StatusStateApplication::RESERVATION,
                    $customProperties = ['comment' => \request('comment')]
                );

            $application_resell->fill(['status' => false, 'cancellation_date' => Carbon::now()->format('Y-m-d')]);
            $application_resell->save();

            DB::commit();
            return $this->sendResponse(
                $id,
                __('lang.api.deleted', ['model' => __('models/application_resells.singular')])
            );

        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError(
                $exception->getMessage()
            );
        }
    }

}
