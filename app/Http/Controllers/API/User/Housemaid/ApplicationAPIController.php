<?php

namespace App\Http\Controllers\API\User\Housemaid;


use App\Http\Requests\User\CreateApplicationAPIRequest;
use App\Http\Requests\User\UpdateApplicationAPIRequest;
use App\Http\Resources\User\ApplicationResource;
use App\Http\Resources\User\Office\ExternalOfficeResource;
use App\Models\Application;
use App\Models\ExternalOffice;
use App\StateMachines\StatusStateApplication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Validation\Rule;

/**
 * Class ApplicationAPIController
 * @package App\Http\Controllers\API\User\Housemaid
 */
class ApplicationAPIController extends AppBaseController
{
    /**
     * Display a listing of the Application.
     * GET|HEAD /applications
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $query = Application::query()->filter()->sorted();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $applications = $query->get();

        return $this->sendResponse(
            ApplicationResource::collection($applications),
            __('lang.api.retrieved', ['model' => __('models/applications.plural')])
        );
    }




    /**
     * Display the specified Application.
     * GET|HEAD /applications/{id}
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function show($id)
    {
        /** @var Application $application */
        $application = Application::with(
            [
                'currency', 'external_office', 'internal_office',
                'sponsor', 'country', 'job', 'religion', 'education',
                'reservation', 'visa', 'expectedArrival', 'arrival', 'deportation',
                'deliver', 'resell',
                'created_by', 'responsible_user', 'external_office_transactions'
            ])->find($id);


        if (empty($application)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/applications.singular')])
            );
        }

//        $data['application'] = new ApplicationResource($application);
//        $data['status_state_application'] = StatusStateApplication::STATES;
        return $this->sendResponse(
            new ApplicationResource($application),
            __('lang.api.retrieved', ['model' => __('models/applications.singular')])
        );
    }

    /**
     * Store a newly created Application in storage.
     *
     * @param CreateApplicationAPIRequest $request
     *
     * @return JsonResponse
     */
    public function store(CreateApplicationAPIRequest $request)
    {
        $request_data = collect($request->validated())->except(['photo', 'full_body_photo'])->toArray();

        if ($request->file('photo'))
            $request_data['photo'] = uploadImage('applications', $request->photo);

        if ($request->file('full_body_photo'))
            $request_data['full_body_photo'] = uploadImage('applications', $request->full_body_photo);

        if ($request->has('external_office_id')) {
            $external_office = ExternalOffice::find($request->input('external_office_id'));
            $request_data['currency_id'] = $external_office->currency_id;
            $request_data['office_commission'] = $external_office->commission;

        }

        $request_data['created_by_id'] = request()->user()->id;


        /** @var Application $application */
        $application = Application::create($request_data);

        $application_external_office_transactions = $request->application_external_office_transactions;
        if (!empty($application_external_office_transactions) && is_array($application_external_office_transactions)) {
            foreach ($request['application_external_office_transactions'] as $application_external_office_transaction)
                $application->external_office_transactions()->attach(
                    $application_external_office_transaction['id'],
                    [
                        'note' => isset($application_external_office_transaction['note']) ? $application_external_office_transaction['note'] : null,
                        'date' => $application_external_office_transaction['date'],
                        'created_by_id' => $request_data['created_by_id'],
                    ]
                );
        }

        return $this->sendResponse(
            new ApplicationResource($application),
            __('lang.api.saved', ['model' => __('models/applications.singular')])
        );
    }

    /**
     * Update the specified Application in storage.
     * PUT/PATCH /applications/{id}
     *
     * @param int $id
     * @param UpdateApplicationAPIRequest $request
     *
     * @return JsonResponse
     */
    public function update($id, UpdateApplicationAPIRequest $request)
    {
        /** @var Application $application */
        $application = Application::find($id);

        if (empty($application)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/applications.singular')])
            );
        }

        $request_data = collect($request->validated())->except(['photo', 'full_body_photo', '_method', '_token'])->toArray();

        if ($request->file('photo'))
            $request_data['photo'] = uploadImage('applications', $request->photo);

        if ($request->file('full_body_photo'))
            $request_data['full_body_photo'] = uploadImage('applications', $request->full_body_photo);


        $application->fill($request_data);
        $application->save();


        return $this->sendResponse(
            new ApplicationResource($application),
            __('lang.api.updated', ['model' => __('models/applications.singular')])
        );
    }

    /**
     * Remove the specified Application from storage.
     * DELETE /applications/{id}
     *
     * @param int $id
     *
     * @return JsonResponse
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var Application $application */
        $application = Application::find($id);

        if (empty($application)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/applications.singular')])
            );
        }

        try {
            $application->delete();
        } catch (\Exception $exception) {
            return $this->sendError(
                __('lang.api.You_cannot_delete_recoded_model')
            );
        }

        return $this->sendResponse(
            $id,
            __('lang.api.deleted', ['model' => __('models/applications.singular')])
        );
    }

    /**
     * @param $external_office_id
     * @return JsonResponse
     */
    public function generateCode($external_office_id)
    {
        $external_office = ExternalOffice::find($external_office_id);
        if (empty($external_office)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/external_offices.singular')])
            );
        }

        $last_id = 1;

        $last_application = Application::latest()->first();
        $last_id = $last_application ? ($last_application->id + 1) : $last_id;

        $code = $external_office->code;

        do {

            $code = strtoupper($code) . '-' . $last_id;
            $last_id++;
        } while (Application::where('code', $code)->exists());

        return $this->sendResponse(
            $code,
            __('lang.api.retrieved', ['model' => __('models/applications.singular')])
        );
    }

    /**
     * @param $external_office_id
     * @return JsonResponse
     */
    public function internalOfficesByExternalOffice($external_office_id)
    {
        $external_office = ExternalOffice::with(['internal_offices'])->find($external_office_id);
        if (empty($external_office)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/external_offices.singular')])
            );
        }
        return $this->sendResponse(
            new ExternalOfficeResource($external_office),
            __('lang.api.retrieved', ['model' => __('models/external_offices.singular')])
        );
    }


    public function change_status($application_id)
    {

        /** @var Application $application */
        $application = Application::with(
            [
                'currency', 'external_office', 'internal_office',
                'sponsor', 'country', 'job', 'religion', 'education',
                'created_by', 'responsible_user', 'external_office_transactions'
            ])->find($application_id);
        if (empty($application)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/applications.singular')])
            );
        }
        $status = \request('status');
        $this->validate(\request(), ['status' => ['required', Rule::in(StatusStateApplication::STATES)]],
            ['status.in' => 'the status must be in ' . implode(',', StatusStateApplication::STATES)]
        );
        $application->status = $status;
        $application->save();

        return $this->sendResponse(
            new ApplicationResource($application),
            __('lang.api.updated', ['model' => __('models/applications.singular')])
        );


    }

    /**
     * Display a listing of the Application.
     *
     * @param $application_id
     * @param Request $request
     * @return JsonResponse
     */
    public function notes($application_id, Request $request)
    {
        $application = Application::find($application_id);

        if (empty($application)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/applications.singular')])
            );
        }

        $application= $application->status()->history()->with('responsible:id,name,photo,email,type,role,model_id,model_type,is_active');

        if ($request->get('limit')) {
            $application->limit($request->get('limit'));
        }
        if ($request->get('skip') && $request->get('limit')) {
            $application->limit($request->get('limit'));
        }

        $notes = $application->latest()->get();

        return $this->sendResponse(
            $notes,
            __('lang.api.retrieved', ['model' => __('models/applications.plural')])
        );
    }


}
