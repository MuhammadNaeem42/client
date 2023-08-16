<?php

namespace App\Http\Controllers\API\User\Housemaid\ApplicationStatus;


use App\Http\Controllers\AppBaseController;
use App\Http\Requests\User\Housemaid\ApplicationStatus\ApplicationVisa\CreateApplicationVisaAPIRequest;
use App\Http\Requests\User\Housemaid\ApplicationStatus\ApplicationVisa\UpdateApplicationVisaAPIRequest;
use App\Http\Resources\User\Housemaid\ApplicationStatus\ApplicationVisaResource;
use App\Models\Application;
use App\Models\ApplicationStatus\ApplicationVisa;
use App\StateMachines\StatusStateApplication;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

/**
 * Class ApplicationVisaAPIController
 * @package App\Http\Controllers\API\User\Housemaid
 */
class ApplicationVisaAPIController extends AppBaseController
{
    /**
     * Display a listing of the ApplicationVisa.
     * GET|HEAD /application_visas
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {


        $query = ApplicationVisa::query()->with(['sponsor', 'created_by', 'application'])->filter()->sorted();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('skip') && $request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $application_visas = $query->get();

        return $this->sendResponse(
            ApplicationVisaResource::collection($application_visas),
            __('lang.api.retrieved', ['model' => __('models/application_visas.plural')])
        );
    }


    /**
     * Display the specified ApplicationVisa.
     * GET|HEAD /application_visas/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var ApplicationVisa $application_visa */
        $application_visa = ApplicationVisa::with(['sponsor', 'created_by', 'application'])->find($id);

        if (empty($application_visa)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/application_visas.singular')])
            );
        }

        return $this->sendResponse(
            new ApplicationVisaResource($application_visa),
            __('lang.api.retrieved', ['model' => __('models/application_visas.singular')])
        );
    }

    /**
     * Store a newly created ApplicationVisa in storage.
     *
     * @param CreateApplicationVisaAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(CreateApplicationVisaAPIRequest $request)
    {
        DB::beginTransaction();
        try {
            $request_data = collect($request->validated())->except(['created_by_id', 'status', 'photo', 'cancellation_date'])->toArray();

            $application = Application::with(['visa'])->find($request->application_id);
            if ($application->visa) {
                return $this->sendError(__('models/application_visas.already_exist'));
            }

            if ($request->file('photo'))
                $request_data['photo'] = uploadImage('application_visas', $request->photo);

            $request_data['passport_id'] = $application->passport_no;

            /** @var ApplicationVisa $application_visa */
            $application_visa = ApplicationVisa::create($request_data);
            if ($application_visa) {
                $application->status()->transitionTo(StatusStateApplication::VISA);
            }

            DB::commit();
            return $this->sendResponse(
                new ApplicationVisaResource($application_visa),
                __('lang.api.saved', ['model' => __('models/application_visas.singular')])
            );
        } catch (\Exception $exception) {
            DB::rollBack();

            return $this->sendError(
                $exception->getMessage()
            );
        }

    }

    /**
     * Update the specified ApplicationVisa in storage.
     * PUT/PATCH /application_visas/{id}
     *
     * @param int $id
     * @param UpdateApplicationVisaAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateApplicationVisaAPIRequest $request)
    {
        /** @var ApplicationVisa $application_visa */
        $application_visa = ApplicationVisa::find($id);

        if (empty($application_visa)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/application_visas.singular')])
            );
        }

        $request_data = collect($request->validated())->except(['created_by_id', '_method', '_token', 'photo', 'cancellation_date', 'status'])->toArray();

        if ($request->file('photo'))
            $request_data['photo'] = uploadImage('application_visas', $request->photo);

        $application_visa->fill($request_data);
        $application_visa->save();


        return $this->sendResponse(
            new ApplicationVisaResource($application_visa),
            __('lang.api.updated', ['model' => __('models/application_visas.singular')])
        );
    }

    /**
     * Cancel ApplicationVisa
     * DELETE /application_visas/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            /** @var ApplicationVisa $application_visa */
            $application_visa = ApplicationVisa::with('application')->active()->find($id);

            if (empty($application_visa)) {
                return $this->sendError(
                    __('lang.api.not_found', ['model' => __('models/application_visas.singular')])
                );
            }

            $application_visa->application
                ->status()->transitionTo(
                    $to = StatusStateApplication::RESERVATION,
                    $customProperties = ['comment' => \request('comment')]
                );

            $application_visa->fill(['status' => false, 'cancellation_date' => Carbon::now()->format('Y-m-d')]);
            $application_visa->save();

            DB::commit();
            return $this->sendResponse(
                $id,
                __('lang.api.deleted', ['model' => __('models/application_visas.singular')])
            );

        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError(
                $exception->getMessage()
            );
        }


    }


}
