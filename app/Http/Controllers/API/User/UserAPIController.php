<?php

namespace App\Http\Controllers\API\User;


use App\Http\Requests\User\CreateUserAPIRequest;
use App\Http\Requests\User\UpdateUserAPIRequest;
use App\Http\Resources\User\UserResource;
use App\Models\ExternalOffice;
use App\Models\InternalOffice;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;

/**
 * Class UserAPIController
 * @package App\Http\Controllers\API\User
 */
class UserAPIController extends AppBaseController
{
    /**
     * Display a listing of the User.
     * GET|HEAD /users
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = User::query()->filter()->sorted();

        if ($request->get('skip')) {
            $query->skip($request->get('skip'));
        }
        if ($request->get('limit')) {
            $query->limit($request->get('limit'));
        }

        $users = $query->get();

        return $this->sendResponse(
            UserResource::collection($users),
            __('lang.api.retrieved', ['model' => __('models/users.plural')])
        );
    }


    /**
     * Display the specified User.
     * GET|HEAD /users/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var User $user */
        $user = User::with(['language', 'country'])->find($id);


        if (empty($user)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/users.singular')])
            );
        }

        return $this->sendResponse(
            new UserResource($user),
            __('lang.api.retrieved', ['model' => __('models/users.singular')])
        );
    }

    /**
     * Store a newly created User in storage.
     *
     * @param CreateUserAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateUserAPIRequest $request)
    {

        $request_data = collect($request->validated())->except(['photo', '_token', 'status'])->toArray();

        if ($request->current_permissions) {
            $current_permissions = collect($request->current_permissions)->intersect(request()->user()->all_permissions)->values()->toArray();
            $request_data['all_permissions'] = $current_permissions;
            $request_data['current_permissions'] = $current_permissions;
        }
//        dd($request_data,$current_permissions);
        //        dd($request->current_permissions, request()->user()->current_permissions, collect($request->current_permissions)->intersect(getAllPermissions()['all_permission']));

        if ($request->file('photo'))
            $request_data['photo'] = uploadImage('users', $request->photo);


        if ($request->has('password') && $request->password != null)
            $request_data['password'] = bcrypt($request->password);

        if ($request->has('status') && $request->status != null)
            $request_data['is_active'] = $request->status;


        if ($request->type == User::$USER_TYPE_EXTERNAL_OFFICE) {
            $request_data['model_type'] = ExternalOffice::class;
        } elseif ($request->type == User::$USER_TYPE_INTERNAL_OFFICE) {
            $request_data['model_type'] = InternalOffice::class;
        } else {
            $request_data['model_type'] = null;
            $request_data['model_id'] = null;
        }

        /** @var User $user */
        $user = User::create($request_data);


        return $this->sendResponse(
            new UserResource($user),
            __('lang.api.saved', ['model' => __('models/users.singular')])
        );
    }

    /**
     * Update the specified User in storage.
     * PUT/PATCH /users/{id}
     *
     * @param int $id
     * @param UpdateUserAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, UpdateUserAPIRequest $request)
    {
        /** @var User $user */
        $user = User::find($id);

        if (empty($user)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/users.singular')])
            );
        }

        $request_data = collect($request->validated())->except(['photo', 'password', '_method', '_token', 'status'])->toArray();

        if ($request->current_permissions) {
            $current_permissions = collect($request->current_permissions)->intersect(request()->user()->all_permissions)->values()->toArray();
            $request_data['all_permissions'] = $current_permissions;
            $request_data['current_permissions'] = $current_permissions;
        }

        if ($request->file('photo'))
            $request_data['photo'] = uploadImage('users', $request->photo);


        if ($request->has('password') && $request->password != null)
            $request_data['password'] = bcrypt($request->password);

        if ($request->has('status') && $request->status != null)
            $request_data['is_active'] = $request->status;


        if ($request->type == User::$USER_TYPE_EXTERNAL_OFFICE)
            $request_data['model_type'] = ExternalOffice::class;
        elseif ($request->type == User::$USER_TYPE_INTERNAL_OFFICE)
            $request_data['model_type'] = InternalOffice::class;
        else {
            $request_data['model_type'] = null;
            $request_data['model_id'] = null;
        }

        $user->fill($request_data);
        $user->save();


        return $this->sendResponse(
            new UserResource($user),
            __('lang.api.updated', ['model' => __('models/users.singular')])
        );
    }

    /**
     * Remove the specified User from storage.
     * DELETE /users/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        /** @var User $user */
        $user = User::find($id);

        if (empty($user)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/users.singular')])
            );
        }

        try {
            $user->delete();
        } catch (\Exception $exception) {
            return $this->sendError(
                __('lang.api.You_cannot_delete_recoded_model')
            );
        }

        return $this->sendResponse(
            $id,
            __('lang.api.deleted', ['model' => __('models/users.singular')])
        );
    }

}
