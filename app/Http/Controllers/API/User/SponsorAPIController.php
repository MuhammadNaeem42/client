<?php

namespace App\Http\Controllers\API\User;


use App\Http\Requests\User\CreateSponsorAPIRequest;
use App\Http\Requests\User\UpdateSponsorAPIRequest;
use App\Http\Resources\User\SponsorResource;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class SponsorAPIController
 * @package App\Http\Controllers\API\User
 */
class SponsorAPIController extends AppBaseController
{
    /**
     * Display a listing of the Sponsor.
     * GET|HEAD /sponsors
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Sponsor::query()->filter()->sorted();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $sponsors = $query->get();

        return $this->sendResponse(
            SponsorResource::collection($sponsors),
            __('lang.api.retrieved', ['model' => __('models/sponsors.plural')])
        );
    }


    /**
     * Display the specified Sponsor.
     * GET|HEAD /sponsors/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var Sponsor $sponsor */
        $sponsor = Sponsor::with(['country', 'job', 'user'])->find($id);

        if (empty($sponsor)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/sponsors.singular')])
            );
        }

        return $this->sendResponse(
            new SponsorResource($sponsor),
            __('lang.api.retrieved', ['model' => __('models/sponsors.singular')])
        );
    }

    /**
     * Store a newly created Sponsor in storage.
     *
     * @param CreateSponsorAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateSponsorAPIRequest $request)
    {

        $request_data = collect($request->validated())->except(['photo', 'front_civil_photo', 'back_civil_photo', 'work_attachments', 'password'])->toArray();

        if ($request->file('photo'))
            $request_data['photo'] = uploadImage('sponsors', $request->photo);

        if ($request->file('front_civil_photo'))
            $request_data['front_civil_photo'] = uploadImage('sponsors', $request->front_civil_photo);

        if ($request->file('back_civil_photo'))
            $request_data['back_civil_photo'] = uploadImage('sponsors', $request->back_civil_photo);

        if ($request->has('work_attachments'))
            $request_data['work_attachments'] = saveArrayImage('sponsors', $request->work_attachments);

        if ($request->has('password') && $request->password != null)
            $request_data['password'] = bcrypt($request->password);

        $request_data['created_by_id'] = request()->user()->id;

        /** @var Sponsor $sponsor */
        $sponsor = Sponsor::create($request_data);

        return $this->sendResponse(
            new SponsorResource($sponsor),
            __('lang.api.saved', ['model' => __('models/sponsors.singular')])
        );
    }

    /**
     * Update the specified Sponsor in storage.
     * PUT/PATCH /sponsors/{id}
     *
     * @param int $id
     * @param UpdateSponsorAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateSponsorAPIRequest $request)
    {
        /** @var Sponsor $sponsor */
        $sponsor = Sponsor::find($id);

        if (empty($sponsor)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/sponsors.singular')])
            );
        }

        $request_data = collect($request->validated())->except(['photo', 'front_civil_photo', 'back_civil_photo', 'work_attachments', 'password', '_method', '_token'])->toArray();

        if ($request->file('photo'))
            $request_data['photo'] = uploadImage('sponsors', $request->photo);

        if ($request->file('front_civil_photo'))
            $request_data['front_civil_photo'] = uploadImage('sponsors', $request->front_civil_photo);

        if ($request->file('back_civil_photo'))
            $request_data['back_civil_photo'] = uploadImage('sponsors', $request->back_civil_photo);


        if ($request->has('work_attachments')) {
            $old_attachments = [];
            if ($request->boolean('work_attachments_append')) {
                $old_attachments = json_decode($sponsor->work_attachments);
            }
            $new_attachments = json_decode(saveArrayImage('sponsors', $request->work_attachments));

            $request_data['work_attachments'] = collect($old_attachments)->merge($new_attachments)->whereNotNull()->toJson();
        }


        if ($request->has('password') && $request->password != null)
            $request_data['password'] = bcrypt($request->password);

        $sponsor->fill($request_data);
        $sponsor->save();


        return $this->sendResponse(
            new SponsorResource($sponsor),
            __('lang.api.updated', ['model' => __('models/sponsors.singular')])
        );
    }

    /**
     * Remove the specified Sponsor from storage.
     * DELETE /sponsors/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var Sponsor $sponsor */
        $sponsor = Sponsor::find($id);

        if (empty($sponsor)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/sponsors.singular')])
            );
        }

        try {
            $sponsor->delete();
        } catch (\Exception $exception) {
            return $this->sendError(
                __('lang.api.You_cannot_delete_recoded_model')
            );
        }

        return $this->sendResponse(
            $id,
            __('lang.api.deleted', ['model' => __('models/sponsors.singular')])
        );
    }

}
