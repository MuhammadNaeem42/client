<?php

namespace App\Http\Controllers\API\User\Housemaid\ApplicationStatus;


use App\Http\Controllers\AppBaseController;
use App\Http\Requests\User\Housemaid\ApplicationStatus\ApplicationReservation\CreateApplicationReservationAPIRequest;
use App\Http\Requests\User\Housemaid\ApplicationStatus\ApplicationReservation\UpdateApplicationReservationAPIRequest;
use App\Http\Resources\User\Housemaid\ApplicationStatus\ApplicationReservationResource;
use App\Models\Application;
use App\Models\ApplicationStatus\ApplicationReservation;
use App\StateMachines\StatusStateApplication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class ApplicationReservationAPIController
 * @package App\Http\Controllers\API\User\Housemaid
 */
class ApplicationReservationAPIController extends AppBaseController
{
    /**
     * Display a listing of the ApplicationReservation.
     * GET|HEAD /application_reservations
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {


        $query = ApplicationReservation::query()->with(['sponsor', 'created_by', 'application'])->filter()->sorted();

        if ($request->get('skip') && $request->get('limit')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $application_reservations = $query->get();

        return $this->sendResponse(
            ApplicationReservationResource::collection($application_reservations),
            __('lang.api.retrieved', ['model' => __('models/application_reservations.plural')])
        );
    }


    /**
     * Display the specified ApplicationReservation.
     * GET|HEAD /application_reservations/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var ApplicationReservation $application_reservation */
        $application_reservation = ApplicationReservation::with(['sponsor', 'created_by', 'application'])->find($id);

        if (empty($application_reservation)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/application_reservations.singular')])
            );
        }

        return $this->sendResponse(
            new ApplicationReservationResource($application_reservation),
            __('lang.api.retrieved', ['model' => __('models/application_reservations.singular')])
        );
    }

    /**
     * Store a newly created ApplicationReservation in storage.
     *
     * @param CreateApplicationReservationAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(CreateApplicationReservationAPIRequest $request)
    {
        DB::beginTransaction();
        try {
            $request_data = collect($request->validated())->except(['created_by_id', 'status'])->toArray();

            $application = Application::with('reservation')->find($request->application_id);
            if ($application->reservation) {
                return $this->sendError(__('models/application_reservations.can_not_reserved'));
            }

            /** @var ApplicationReservation $application_reservation */
            $application_reservation = ApplicationReservation::create($request_data);
            if ($application_reservation) {
                $application->status()->transitionTo(StatusStateApplication::RESERVATION);
            }
            DB::commit();
            return $this->sendResponse(
                new ApplicationReservationResource($application_reservation),
                __('lang.api.saved', ['model' => __('models/application_reservations.singular')])
            );
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError(
                $exception->getMessage()
            );
        }
    }

    /**
     * Update the specified ApplicationReservation in storage.
     * PUT/PATCH /application_reservations/{id}
     *
     * @param int $id
     * @param UpdateApplicationReservationAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateApplicationReservationAPIRequest $request)
    {
        /** @var ApplicationReservation $application_reservation */
        $application_reservation = ApplicationReservation::find($id);

        if (empty($application_reservation)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/application_reservations.singular')])
            );
        }

        $request_data = collect($request->validated())->except(['created_by_id', '_method', '_token', 'status'])->toArray();


        $application_reservation->fill($request_data);
        $application_reservation->save();


        return $this->sendResponse(
            new ApplicationReservationResource($application_reservation),
            __('lang.api.updated', ['model' => __('models/application_reservations.singular')])
        );
    }

    /**
     * Cancel ApplicationReservation
     * DELETE /application_reservations/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     *
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            /** @var ApplicationReservation $application_reservation */
            $application_reservation = ApplicationReservation::with('application')->active()->find($id);

            if (empty($application_reservation)) {
                return $this->sendError(
                    __('lang.api.not_found', ['model' => __('models/application_reservations.singular')])
                );
            }


            $application_reservation->application
                ->status()->transitionTo(
                    $to = StatusStateApplication::APPLICATION,
                    $customProperties = ['comment' => \request('comment')]
                );

            $application_reservation->fill(['status' => false, 'cancellation_date' => Carbon::now()->format('Y-m-d')]);
            $application_reservation->save();

            DB::commit();
            return $this->sendResponse(
                $id,
                __('lang.api.deleted', ['model' => __('models/application_reservations.singular')])
            );
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->sendError(
                $exception->getMessage()
            );
        }


    }


}
