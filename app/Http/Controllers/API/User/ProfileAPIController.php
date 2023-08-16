<?php

namespace App\Http\Controllers\API\User;


use App\Http\Controllers\AppBaseController;


use App\Http\Requests\User\UpdateProfileAPIRequest;

use App\Http\Resources\User\UserResource;
use App\Models\User;


class ProfileAPIController extends AppBaseController
{



    /**
     * Update the specified User in storage.
     *
     * @param UpdateProfileAPIRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProfileAPIRequest $request)
    {
        /** @var User $user */
        $user = User::with(['country','language'])->find(request()->user()->id);

        if (empty($user)) {
            return $this->sendError(
                __('lang.api.not_found', ['model' => __('models/users.singular')])
            );
        }

        $request_data = collect($request->validated())->only(['name','signature','country_id','language_id','email','device_token'])->toArray();

        if ($request->file('photo'))
            $request_data['photo'] = uploadImage('users', $request->photo);


        if ($request->has('password') && !empty($request->password) )
            $request_data['password'] = bcrypt($request->password);


        $user->fill($request_data);
        $user->save();


        return $this->sendResponse(
            new UserResource($user),
            __('lang.api.updated', ['model' => __('models/users.singular')])
        );
    }


    protected function me()
    {
        $user = User::with(['country','language'])->find(request()->user()->id);
        return $this->sendResponse(
            new UserResource($user),
            __('lang.api.retrieved', ['model' => __('models/users.singular')])
        );

    }


}
