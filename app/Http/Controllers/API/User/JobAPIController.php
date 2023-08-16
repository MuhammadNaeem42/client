<?php

namespace App\Http\Controllers\API\User;


use App\Http\Requests\User\CreateJobAPIRequest;
use App\Http\Requests\User\UpdateJobAPIRequest;
use App\Http\Resources\User\JobResource;
use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class JobAPIController
 * @package App\Http\Controllers\API\User
 */
class JobAPIController extends AppBaseController
{
    /**
     * Display a listing of the Job.
     * GET|HEAD /jobs
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Job::query()->filter()->sorted();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $jobs = $query->get();

        return $this->sendResponse(
            JobResource::collection($jobs),
            __('lang.api.retrieved', ['model' => __('models/jobs.plural')])
        );
    }


    /**
     * Display the specified Job.
     * GET|HEAD /jobs/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var Job $job */
        $job = Job::find($id);

        if (empty($job)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/jobs.singular')])
            );
        }

        return $this->sendResponse(
            new JobResource($job),
            __('lang.api.retrieved', ['model' => __('models/jobs.singular')])
        );
    }

    /**
     * Store a newly created Job in storage.
     *
     * @param CreateJobAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateJobAPIRequest $request)
    {

        $request_data = $request->validated();


        /** @var Job $job */
        $job = Job::create($request_data);

        return $this->sendResponse(
            new JobResource($job),
            __('lang.api.saved', ['model' => __('models/jobs.singular')])
        );
    }

    /**
     * Update the specified Job in storage.
     * PUT/PATCH /jobs/{id}
     *
     * @param int $id
     * @param UpdateJobAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateJobAPIRequest $request)
    {
        /** @var Job $job */
        $job = Job::find($id);

        if (empty($job)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/jobs.singular')])
            );
        }

        $request_data = $request->except(['_method', '_token']);


        $job->fill($request_data);
        $job->save();


        return $this->sendResponse(
            new JobResource($job),
            __('lang.api.updated', ['model' => __('models/jobs.singular')])
        );
    }

    /**
     * Remove the specified Job from storage.
     * DELETE /jobs/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var Job $job */
        $job = Job::find($id);

        if (empty($job)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/jobs.singular')])
            );
        }

        try {
            $job->delete();
        } catch (\Exception $exception) {
            return $this->sendError(
                __('lang.api.You_cannot_delete_recoded_model')
            );
        }

        return $this->sendResponse(
            $id,
            __('lang.api.deleted', ['model' => __('models/jobs.singular')])
        );
    }

}
